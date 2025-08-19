<?php

namespace Modules\Iuser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Model;

use Modules\Iuser\Repositories\RoleRepository;
use Modules\Iuser\Support\Permissions\PermissionManager;

class CreateRolesSeeder extends Seeder
{

    private $schedule;
    private $roleRepository;
    private $permissions;

    public function __construct(
        Schedule $schedule,
        RoleRepository $roleRepository,
        PermissionManager $permissions
    ) {
        $this->schedule = $schedule;
        $this->roleRepository = $roleRepository;
        $this->permissions = $permissions;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        //Version anterior
        $this->schedule->command('php artisan config:clear');

        $this->createSuperAdminRol();
        $this->createUserRol();
        $this->createAdminRol();
    }

    /**
     * TODO: Permisos, probar si no se asignan permisos y se utiliza lo del gate
     */
    private function createSuperAdminRol(): void
    {
        $roleData = [
            'system_name' => 'super-admin',
            'en' => ['title' => itrans("iuser::roles.types.super admin", [], "en")],
            'es' => ['title' => itrans("iuser::roles.types.super admin", [], "es")]
        ];

        $role = $this->roleRepository->updateOrCreate(['system_name' => 'super-admin'], $roleData);
    }

    /**
     * TODO: Este creo que no lleva permisos por defecto
     */
    private function createUserRol(): void
    {
        $roleData = [
            'system_name' => 'user',
            'en' => ['title' => itrans("iuser::roles.types.user", [], "en")],
            'es' => ['title' => itrans("iuser::roles.types.user", [], "es")]
        ];

        $role = $this->roleRepository->updateOrCreate(['system_name' => 'user'], $roleData);
    }

    /**
     * Create the Admin role with all permissions.
     */
    private function createAdminRol(): void
    {

        $roleData = [
            'system_name' => 'admin',
            'en' => ['title' => itrans("iuser::roles.types.admin", [], "en")],
            'es' => ['title' => itrans("iuser::roles.types.admin", [], "es")]
        ];

        $role = $this->roleRepository->updateOrCreate(['system_name' => 'admin'], $roleData);

        //Set all permissions
        //$this->setAllPermissions($role);

    }

    /**
     * Set all permissions for the given role.
     *
     */
    private function setAllPermissions($role): void
    {

        $permissions = $this->permissions->all();

        $modules = array_keys(app('modules')->allEnabled());
        $allPermissions = [];

        //Get permissions and set true
        foreach ($permissions as $moduleName => $modulePermissions) {
            if (in_array($moduleName, $modules)) {
                foreach ($modulePermissions as $entityName => $entityPermissions) {
                    foreach ($entityPermissions as $permissionName => $permission) {
                        $allPermissions["{$entityName}.{$permissionName}"] = true;
                    }
                }
            }
        }

        //Set all permissions to the role
        $role->permissions = $allPermissions;
        $role->save();
    }
}
