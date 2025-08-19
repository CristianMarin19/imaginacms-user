<?php

namespace Modules\Iuser\Traits;

trait RolePermissionTrait
{

    /**
     * Get the roles associated with the user.
     * @param string|array $role
     */
    public function hasRole($role): bool
    {
        if (is_array($role))
            return $this->roles->whereIn('system_name', $role)->isNotEmpty();

        return $this->roles->contains('system_name', $role);
    }

    /**
     * Get the permissions associated with the user.
     */
    public function hasPermission($permission): bool
    {

        //Get data from permission
        $permissionInfo = explode('.', $permission);
        //Get config with Module Name
        $permissionConfig = config($permissionInfo[0] . '.permissions');
        //Get the base permission name | Example: ['iuser.users']['manage'];
        $dataPermission = $permissionConfig[$permissionInfo[0] . '.' . $permissionInfo[1]][$permissionInfo[2]];

        return $this->validatePermission($dataPermission, $permission);
    }

    /**
     * Used by Middleware and User Model
     */
    public function validatePermission($dataPermission, $permission = null): bool
    {

        //Validation Super Admin
        if ($this->hasRole('super-admin'))
            return true;

        //Check if the permission is not restricted to super-admins only
        if ($this->hasRole('admin')) {
            if (isset($dataPermission['onlyFor']) && in_array('super-admin', $dataPermission['onlyFor'])) {
                return false;
            }
            return true;
        }

        //Check if the permission is in defaultAccess
        if ($this->hasRole('user')) {
            if (isset($dataPermission['defaultAccess']) && in_array('user', $dataPermission['defaultAccess'])) {
                return true;
            }
        }

        // Case: User has the permission directly
        $userPermissions = isset($this->attributes['permissions'])
            ? json_decode($this->attributes['permissions'], true)
            : [];

        if (isset($userPermissions[$permission])) {
            return $userPermissions[$permission];
        } else {
            //Check if the Role from User has the permission
            return $this->roles->contains(function ($role) use ($permission) {
                return isset($role->permissions[$permission]) && $role->permissions[$permission] === true;
            });
        }
    }
}
