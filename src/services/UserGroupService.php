<?php

namespace App\services;

use App\models\Group;
use App\models\Permission;
use App\models\User;

class UserGroupService
{
    public function addUserToGroup($userId): void
    {
        $user = User::find($userId);
        $group = Group::find($userId);

        if (!$user || !$group) {
            throw new \Exception('User or group not found');
        }

        $user->groups()->attach($group);
    }

    public function removeUserFromGroup($userId): void
    {
        $user = User::find($userId);
        $group = Group::find($userId);

        if (!$user || !$group) {
            throw new \Exception('User or group not found');
        }

        $user->groups()->detach($group);
    }

    public function listGroups()
    {
        return Group::select(['name', 'id'])
            ->with(['permissions' => function ($query) {
                $query->select(['name', 'id']);
            }])
            ->get();
    }

    public function userPermissions($userId): array
    {
        $user = User::find($userId);

        if (!$user) {
            throw new \Exception('User not found');
        }

        $permissions = $user->groups()->with('permissions')->get()->pluck('permissions')->flatten()->unique('id');
        $blockedPermissions = $user->blockedPermissions()->pluck('id')->toArray();

        $result = [];

        foreach (Permission::all() as $permission) {
            $hasPermission = $permissions->contains('id', $permission->id) && !in_array($permission->id, $blockedPermissions, true);
            $result[$permission->name] = $hasPermission;
        }
        return $result;
    }

    public function blockPermission($userId, $permissionName): void
    {
        $user = User::find($userId);
        $permission = Permission::where('name', $permissionName)->first();

        if (!$user || !$permission) {
            throw new \Exception('User or permission not found');
        }

        $user->blockedPermissions()->attach($permission);
    }

    public function unblockPermission($userId, $permissionName): void
    {
        $user = User::find($userId);
        $permission = Permission::where('name', $permissionName)->first();

        if (!$user || !$permission) {
            throw new \Exception('User or permission not found');
        }

        $user->blockedPermissions()->detach($permission);
    }
}