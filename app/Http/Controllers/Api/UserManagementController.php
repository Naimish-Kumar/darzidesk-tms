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
    private function hasUserPermission($user, $permission)
    {
        if (!$user) return false;
        if (in_array(strtolower($user->type ?? ''), ['owner', 'super admin', 'admin', 'super_admin', 'system admin'])) {
            return true;
        }
        if ($user->id == parentId()) {
            return true;
        }
        return $user->can($permission);
    }

    public function getRoles()
    {
        $user = Auth::user();
        if (!$this->hasUserPermission($user, 'manage role')) {
            return response()->json(['success' => false, 'message' => 'Permission Denied.'], 403);
        }

        $rolesQuery = Role::where('parent_id', parentId())
            ->whereNotIn(\DB::raw('LOWER(name)'), ['admin', 'super admin', 'super_admin', 'system admin', 'system_admin']);

        $roles = $rolesQuery->orderBy('id', 'desc')
            ->get()
            ->map(function ($role) {
                $userCount = User::where('role_id', $role->id)->orWhereHas('roles', function($q) use ($role) {
                    $q->where('id', $role->id);
                })->count();

                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'user_count' => $userCount,
                    'permissions' => $role->permissions->pluck('id')->toArray(),
                ];
            });

        // Auto-seed default permissions if none exist in system
        if (Permission::count() == 0) {
            $defaultPermissions = [
                'manage order', 'create order', 'edit order', 'delete order',
                'manage measurement', 'create measurement', 'edit measurement',
                'manage customer', 'create customer', 'edit customer',
                'manage invoice', 'create invoice', 'process payment',
                'manage expense', 'create expense',
                'manage staff', 'create staff', 'edit staff', 'delete staff',
                'manage role', 'create role', 'edit role', 'delete role',
                'view reports', 'manage inventory', 'manage branch'
            ];
            foreach ($defaultPermissions as $perm) {
                Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
            }
        }

        // Get all system permissions for dynamic assignment
        $allPermissions = Permission::orderBy('name', 'asc')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
            ];
        })->toArray();

        return response()->json([
            'success' => true,
            'roles' => $roles,
            'all_permissions' => $allPermissions,
        ]);
    }

    public function storeRole(Request $request)
    {
        $user = Auth::user();
        if (!$this->hasUserPermission($user, 'create role')) {
            return response()->json(['success' => false, 'message' => 'Permission Denied.'], 403);
        }

        $roleNameLower = strtolower(trim($request->name));
        if (in_array($roleNameLower, ['admin', 'super admin', 'super_admin', 'system admin', 'owner', 'customer'])) {
            return response()->json(['success' => false, 'message' => 'Shop owners cannot create Admin or System reserved roles.'], 400);
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
        if (!$this->hasUserPermission($user, 'edit role')) {
            return response()->json(['success' => false, 'message' => 'Permission Denied.'], 403);
        }

        $role = Role::where('id', $id)->where('parent_id', parentId())->first();
        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Role not found.'], 404);
        }

        $roleNameLower = strtolower(trim($role->name));
        if (in_array($roleNameLower, ['admin', 'super admin', 'super_admin', 'system admin', 'owner', 'customer'])) {
            return response()->json(['success' => false, 'message' => 'Shop owners cannot modify Admin or Built-in roles.'], 400);
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
        if (!$this->hasUserPermission($user, 'delete role')) {
            return response()->json(['success' => false, 'message' => 'Permission Denied.'], 403);
        }

        $role = Role::where('id', $id)->where('parent_id', parentId())->first();
        if (!$role) {
            return response()->json(['success' => false, 'message' => 'Role not found.'], 404);
        }

        $roleNameLower = strtolower(trim($role->name));
        if (in_array($roleNameLower, ['admin', 'super admin', 'super_admin', 'system admin', 'owner', 'customer'])) {
            return response()->json(['success' => false, 'message' => 'Shop owners cannot delete Admin or Built-in roles.'], 400);
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
        if (!$this->hasUserPermission($user, 'manage logged history')) {
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
        if (!$this->hasUserPermission($user, 'delete logged history')) {
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
