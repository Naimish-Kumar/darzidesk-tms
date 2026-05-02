<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $query = User::where('parent_id', parentId())
            ->whereNotIn('type', ['customer', 'super admin', 'owner']);
            
        if ($user->type == 'manager') {
            $query->where('type', 'employee');
        }

        $staff = $query->orderBy('id', 'desc')->get()->map(function($u) {
            return [
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'type' => ucfirst($u->type),
                'phone' => $u->phone_number,
                'profile' => !empty($u->profile) ? asset('/storage/upload/profile/' . $u->profile) : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $staff
        ]);
    }

    public function getRoles()
    {
        $roles = Role::where('parent_id', parentId())
            ->whereNotIn('name', ['customer', 'owner'])
            ->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        
        $role = Role::findById($request->role);
        $user->type = $role->name;
        $user->parent_id = parentId();
        $user->profile = 'avatar.png';
        $user->lang = 'english';
        $user->email_verified_at = now();
        $user->save();

        $user->assignRole($role);

        return response()->json([
            'success' => true,
            'message' => 'Staff member created successfully',
            'data' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->where('parent_id', parentId())->first();
        if ($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Staff member deleted']);
        }
        return response()->json(['success' => false, 'message' => 'Staff member not found'], 404);
    }
}
