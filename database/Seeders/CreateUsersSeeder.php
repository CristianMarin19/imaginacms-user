<?php

namespace Modules\Iuser\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Iuser\Repositories\UserRepository;
use Modules\Iuser\Repositories\RoleRepository;

class CreateUsersSeeder extends Seeder
{

    private $userRepository;
    private $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $this->createSuperAdminUser();
    }

    /**
     * Commented | It was changed to a "command"
     */
    private function createSuperAdminUser(): void
    {

        $params = json_decode(json_encode(["filter" => ["field" => "email"]]));
        $user = $this->userRepository->getItem($email, $params);

        /* if (empty($user)) {

            //Data Base
            $data = [
                'email' => $email,
                'password' => $password,
                'first_name' => 'Imagina',
                'last_name' => 'Colombia'
            ];

            $user = $this->userRepository->create($data);

            //TO CHECK: //In seeder , repo validations "beforeCreate" are not applied :/
            if ($user) {
                $params = json_decode(json_encode(["filter" => ["field" => "system_name"]]));
                $role = $this->roleRepository->getItem("super-admin", $params);
                if (!empty($role)) {
                    $user->roles()->attach($role->id);
                }
            }
        } */
    }
}
