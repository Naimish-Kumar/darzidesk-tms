<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('type', ['staff', 'tailor', 'worker']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $staffMembers = $query->latest()->get();
        $totalStaff = $staffMembers->count();
        $activeStaff = $staffMembers->where('is_active', 1)->count();
        $branchesCount = Branch::count();

        return view('staff.index', compact('staffMembers', 'totalStaff', 'activeStaff', 'branchesCount'));
    }

    public function onboardStep1()
    {
        return view('staff.onboard-step1');
    }

    public function storeOnboardStep1(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone_number' => 'nullable|string|max:50',
            'role' => 'nullable|string|max:100',
        ]);

        session(['staff_onboard_draft' => $validated]);

        return redirect()->route('staff.onboard.step2');
    }

    public function onboardStep2()
    {
        $draft = session('staff_onboard_draft', []);
        $branches = Branch::all();
        return view('staff.onboard-step2', compact('draft', 'branches'));
    }

    public function storeOnboardStep2(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'nullable|exists:branches,id',
            'specialization' => 'nullable|string|max:255',
            'shift' => 'nullable|string|max:100',
        ]);

        $draft = session('staff_onboard_draft', []);
        session(['staff_onboard_draft' => array_merge($draft, $validated)]);

        return redirect()->route('staff.onboard.step3');
    }

    public function onboardStep3()
    {
        $draft = session('staff_onboard_draft', []);
        $branch = !empty($draft['branch_id']) ? Branch::find($draft['branch_id']) : null;
        return view('staff.onboard-step3', compact('draft', 'branch'));
    }

    public function storeOnboardStep3(Request $request)
    {
        $draft = session('staff_onboard_draft', []);

        if (empty($draft['name']) || empty($draft['email'])) {
            return redirect()->route('staff.onboard.step1')->with('error', 'Please fill in staff basic details first.');
        }

        User::create([
            'name' => $draft['name'],
            'email' => $draft['email'],
            'phone_number' => $draft['phone_number'] ?? null,
            'password' => Hash::make('Password@123'),
            'type' => 'staff',
            'is_active' => 1,
            'email_verified_at' => now(),
        ]);

        session()->forget('staff_onboard_draft');

        return redirect()->route('staff.index')->with('success', 'Staff member onboarded successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member removed successfully.');
    }
}
