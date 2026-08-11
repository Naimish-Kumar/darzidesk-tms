<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $query = Branch::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $branches = $query->with('manager')->get();
        $totalBranches = $branches->count();
        $activeBranches = $branches->where('is_active', 1)->count();
        $totalStaff = User::where('type', 'staff')->count();

        return view('branch.index', compact('branches', 'totalBranches', 'activeBranches', 'totalStaff'));
    }

    public function createStep1()
    {
        return view('branch.create-step1');
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
        ]);

        session(['branch_draft' => $validated]);

        return redirect()->route('branches.create.step2');
    }

    public function createStep2()
    {
        $draft = session('branch_draft', []);
        $managers = User::whereIn('type', ['owner', 'staff'])->get();
        return view('branch.create-step2', compact('draft', 'managers'));
    }

    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'manager_id' => 'nullable|exists:users,id',
            'operating_hours' => 'nullable|string|max:255',
            'capacity' => 'nullable|numeric',
        ]);

        $draft = session('branch_draft', []);
        session(['branch_draft' => array_merge($draft, $validated)]);

        return redirect()->route('branches.create.step3');
    }

    public function createStep3()
    {
        $draft = session('branch_draft', []);
        $manager = !empty($draft['manager_id']) ? User::find($draft['manager_id']) : null;
        return view('branch.create-step3', compact('draft', 'manager'));
    }

    public function storeStep3(Request $request)
    {
        $draft = session('branch_draft', []);

        if (empty($draft['name'])) {
            return redirect()->route('branches.create.step1')->with('error', 'Please fill in branch basic details first.');
        }

        Branch::create([
            'name' => $draft['name'],
            'code' => $draft['code'] ?? 'BR-'.rand(100, 999),
            'address' => $draft['address'] ?? null,
            'phone' => $draft['phone'] ?? null,
            'manager_id' => $draft['manager_id'] ?? null,
            'is_active' => 1,
        ]);

        session()->forget('branch_draft');

        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');
    }
}
