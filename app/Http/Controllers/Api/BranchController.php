<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::where('parent_id', parentId())
            ->with('manager')
            ->orderBy('id', 'asc')
            ->get();

        if ($branches->isEmpty()) {
            // Seed main branch automatically if none exists
            $mainBranch = Branch::create([
                'name' => 'Main Studio',
                'code' => 'BR-MAIN',
                'address' => 'Primary Boutique Location',
                'parent_id' => parentId(),
            ]);
            $branches = Branch::where('parent_id', parentId())->with('manager')->get();
        }

        return response()->json([
            'success' => true,
            'branches' => $branches->map(function ($b) {
                return [
                    'id' => $b->id,
                    'name' => $b->name,
                    'code' => $b->code ?? 'BR-' . $b->id,
                    'address' => $b->address ?? '',
                    'phone' => $b->phone ?? '',
                    'manager_name' => $b->manager->name ?? 'Unassigned',
                ];
            }),
            'active_branch_id' => session('active_branch_id', $branches->first()->id ?? 1),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        $branch = Branch::create([
            'name' => $request->name,
            'code' => $request->code ?? ('BR-' . rand(100, 999)),
            'phone' => $request->phone,
            'address' => $request->address,
            'parent_id' => parentId(),
        ]);

        return response()->json(['success' => true, 'message' => 'Branch location created successfully', 'branch' => $branch]);
    }

    public function switchBranch(Request $request)
    {
        $request->validate(['branch_id' => 'required|integer']);

        $branch = Branch::where('parent_id', parentId())->findOrFail($request->branch_id);
        session(['active_branch_id' => $branch->id]);

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
}
