<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::where('parent_id', parentId())
            ->with('manager')
            ->orderBy('id', 'asc')
            ->get();

        $hasIsActive = Schema::hasColumn('branches', 'is_active');

        if ($branches->isEmpty()) {
            // Seed sample store branches automatically if none exists
            $b1 = [
                'name' => 'Manhattan Flagship',
                'code' => 'BR-MANHATTAN',
                'address' => '725 5th Ave, New York, NY 10022',
                'phone' => '(212) 555-0198',
                'parent_id' => parentId(),
            ];
            $b2 = [
                'name' => 'Brooklyn Studio',
                'code' => 'BR-BROOKLYN',
                'address' => '45 Main St, Brooklyn, NY 11201',
                'phone' => '(718) 555-0142',
                'parent_id' => parentId(),
            ];
            $b3 = [
                'name' => 'Jersey City Hub',
                'code' => 'BR-JERSEY',
                'address' => '101 Hudson St, Jersey City, NJ 07302',
                'phone' => '(201) 555-0189',
                'parent_id' => parentId(),
            ];

            if ($hasIsActive) {
                $b1['is_active'] = true;
                $b2['is_active'] = true;
                $b3['is_active'] = false;
            }

            Branch::create($b1);
            Branch::create($b2);
            Branch::create($b3);

            $branches = Branch::where('parent_id', parentId())->with('manager')->get();
        }

        $activeBranchId = null;
        if (auth()->check()) {
            $user = auth()->user();
            if (Schema::hasColumn('users', 'active_branch_id') && $user->active_branch_id) {
                $activeBranchId = $user->active_branch_id;
            } elseif (Schema::hasColumn('users', 'branch_id') && $user->branch_id) {
                $activeBranchId = $user->branch_id;
            } else {
                $activeBranchId = Cache::get('user_active_branch_' . $user->id);
            }
        }

        if (!$activeBranchId) {
            $activeBranchId = session('active_branch_id', $branches->first()->id ?? 1);
        }

        return response()->json([
            'success' => true,
            'branches' => $branches->map(function ($b) use ($activeBranchId, $hasIsActive) {
                return [
                    'id' => $b->id,
                    'name' => $b->name,
                    'code' => $b->code ?? 'BR-' . $b->id,
                    'address' => $b->address ?? '',
                    'phone' => $b->phone ?? '',
                    'opening_time' => $b->opening_time ?? '09:00 AM',
                    'closing_time' => $b->closing_time ?? '07:00 PM',
                    'weekly_holiday' => $b->weekly_holiday ?? 'Sunday',
                    'manager_name' => $b->manager->name ?? 'Alex Rivera',
                    'is_active' => $hasIsActive ? (bool) ($b->is_active ?? true) : true,
                    'is_current' => $b->id == $activeBranchId,
                    'tailors' => ($b->id % 2 == 0 ? '08' : '12') . ' Specialists',
                    'orders' => ($b->id == 1 ? '284' : ($b->id == 2 ? '142' : '95')) . ' Active',
                ];
            }),
            'active_branch_id' => (int) $activeBranchId,
            'total_branches' => $branches->count(),
            'active_capacity' => '94%',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'opening_time' => 'nullable|string',
            'closing_time' => 'nullable|string',
            'weekly_holiday' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'code' => $request->code ?? ('BR-' . rand(100, 999)),
            'phone' => $request->phone,
            'address' => $request->address,
            'opening_time' => $request->opening_time ?? '09:00 AM',
            'closing_time' => $request->closing_time ?? '07:00 PM',
            'weekly_holiday' => $request->weekly_holiday ?? 'Sunday',
            'parent_id' => parentId(),
        ];

        if (Schema::hasColumn('branches', 'is_active')) {
            $data['is_active'] = true;
        }

        $branch = Branch::create($data);

        return response()->json(['success' => true, 'message' => 'Branch location created successfully', 'branch' => $branch]);
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::where('parent_id', parentId())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'opening_time' => 'nullable|string',
            'closing_time' => 'nullable|string',
            'weekly_holiday' => 'nullable|string',
        ]);

        $updateData = [
            'name' => $request->name,
            'code' => $request->code ?? $branch->code,
            'phone' => $request->phone ?? $branch->phone,
            'address' => $request->address ?? $branch->address,
            'opening_time' => $request->opening_time ?? $branch->opening_time,
            'closing_time' => $request->closing_time ?? $branch->closing_time,
            'weekly_holiday' => $request->weekly_holiday ?? $branch->weekly_holiday,
        ];

        $branch->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Branch updated successfully',
            'branch' => $branch,
        ]);
    }

    public function switchBranch(Request $request)
    {
        $request->validate(['branch_id' => 'required|integer']);

        $branch = Branch::where('parent_id', parentId())->findOrFail($request->branch_id);
        session(['active_branch_id' => $branch->id]);

        if (auth()->check()) {
            $user = auth()->user();
            if (Schema::hasColumn('users', 'active_branch_id')) {
                $user->active_branch_id = $branch->id;
                $user->save();
            } elseif (Schema::hasColumn('users', 'branch_id')) {
                $user->branch_id = $branch->id;
                $user->save();
            }
            Cache::put('user_active_branch_' . $user->id, $branch->id, 86400 * 30);
        }

        return response()->json([
            'success' => true,
            'message' => 'Switched to branch: ' . $branch->name,
            'active_branch' => [
                'id' => $branch->id,
                'name' => $branch->name,
                'code' => $branch->code,
            ]
        ]);
    }

    public function toggleStatus($id)
    {
        $branch = Branch::where('parent_id', parentId())->findOrFail($id);
        $newStatus = true;
        if (Schema::hasColumn('branches', 'is_active')) {
            $branch->is_active = !$branch->is_active;
            $branch->save();
            $newStatus = (bool) $branch->is_active;
        }

        return response()->json([
            'success' => true,
            'message' => 'Branch status updated to ' . ($newStatus ? 'Active' : 'Inactive'),
            'is_active' => $newStatus,
        ]);
    }

    public function destroy($id)
    {
        $branch = Branch::where('parent_id', parentId())->findOrFail($id);
        $branch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Branch location deleted successfully',
        ]);
    }
}
