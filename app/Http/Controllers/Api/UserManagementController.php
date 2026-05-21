<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LoggedHistory;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function getRoles()
    {
        $user = Auth::user();
        if (!$user->can('manage role')) {
            return response()->json(['success' => false, 'message' => 'Permission Denied.'], 403);
        }

        $roles = Role::where('parent_id', parentId())
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'permissions' => $role->permissions->pluck('id')->toArray(),
                ];
            });

        // Get permissions that the current user owns (so they can grant them)
        $ownerPermissions = $user->permissions->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
            ];
        })->toArray();

        // If the owner has no direct permissions, fall back to getting roles' permissions
        if (empty($ownerPermissions)) {
            $permissionList = collect();
            foreach ($user->roles as $role) {
                $permissionList = $permissionList->merge($role->permissions);
            }
            $ownerPermissions = $permissionList->unique('id')->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                ];
            })->values()->toArray();
        }

        return response()->json([
            'success' => true,
            'roles' => $roles,
            'all_permissions' => $ownerPermissions,
        ]);
    }

    public function storeRole(Request $request)
    {
        $user = Auth::user();
        if (!$user->can('create role')) {
            return response()->json(['success' => false, 'message' => 'Permission Denied.'], 403);
        }

        $validator = \Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,null,id,parent_id,' . parentId(),
            'permissions' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $role = new Role();
        $role->name = $request->name;
        $role->parent_id = parentId();
        $role->save();

        if (!empty($request->permissions)) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role successfully created.',
            'data' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('id')->toArray(),
            ]
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->can('edit role')) {
            return response()->json(['success' => false, 'message' => 'Permission Denied.'], 403);
        }

        $role = Role::where('id', $id)->where('parent_id', parentId())->first();
        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Role not found.'], 404);
        }

        if (in_array($role->name, ['owner', 'customer'])) {
            return response()->json(['success' => false, 'message' => 'Built-in roles cannot be edited.'], 400);
        }

        $validator = \Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $role->id . ',id,parent_id,' . parentId(),
            'permissions' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $role->name = $request->name;
        $role->save();

        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return response()->json([
            'success' => true,
            'message' => 'Role successfully updated.',
            'data' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('id')->toArray(),
            ]
        ]);
    }

    public function destroyRole($id)
    {
        $user = Auth::user();
        if (!$user->can('delete role')) {
            return response()->json(['success' => false, 'message' => 'Permission Denied.'], 403);
        }

        $role = Role::where('id', $id)->where('parent_id', parentId())->first();
        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Role not found.'], 404);
        }

        if (in_array($role->name, ['owner', 'customer'])) {
            return response()->json(['success' => false, 'message' => 'Built-in roles cannot be deleted.'], 400);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role successfully deleted.'
        ]);
    }

    public function getLoggedHistory()
    {
        $user = Auth::user();
        if (!$user->can('manage logged history')) {
            return response()->json(['success' => false, 'message' => 'Permission Denied.'], 403);
        }

        $authUser = User::find(parentId());
        $subscription = Subscription::find($authUser->subscription);
        $pricing_feature_settings = getSettingsValByIdName(1, 'pricing_feature');

        $isHistoryEnabled = ($pricing_feature_settings == 'off' || (optional($subscription)->enabled_logged_history == 1));
        if (!$isHistoryEnabled) {
            return response()->json([
                'success' => false,
                'is_disabled_by_plan' => true,
                'message' => 'Logged history feature is not enabled under your current subscription plan. Please upgrade.'
            ]);
        }

        $histories = LoggedHistory::where('parent_id', parentId())
            ->with('user')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($h) {
                return [
                    'id' => $h->id,
                    'ip' => $h->ip,
                    'date' => $h->date,
                    'details' => $h->details,
                    'type' => $h->type,
                    'user_name' => optional($h->user)->name ?? 'Unknown User',
                    'user_email' => optional($h->user)->email ?? '',
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $histories
        ]);
    }

    public function destroyLoggedHistory($id)
    {
        $user = Auth::user();
        if (!$user->can('delete logged history')) {
            return response()->json(['success' => false, 'message' => 'Permission Denied.'], 403);
        }

        $history = LoggedHistory::where('id', $id)->where('parent_id', parentId())->first();
        if (!$history) {
            return response()->json(['success' => false, 'message' => 'History log not found.'], 404);
        }

        $history->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged history successfully deleted.'
        ]);
    }
}
