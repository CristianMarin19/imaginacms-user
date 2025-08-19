<?php

namespace Modules\Iuser\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Modules\Iuser\Repositories\UserRepository;
use Modules\Iuser\Repositories\RoleRepository;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'iuser:create-super-admin {email} {first_name} {last_name}';

    /**
     * The console command description.
     */
    protected $description = 'Create super admin';

    private $userRepository;
    private $roleRepository;

    /**
     * Create a new command instance.
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("-> Create Super Admin");

        $email = $this->argument('email');
        $firstName = $this->argument('first_name');
        $lastName = $this->argument('last_name');

        $params = json_decode(json_encode(["filter" => ["field" => "email"]]));
        $user = $this->userRepository->getItem($email, $params);

        if (empty($user)) {

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error("❌ Invalid email format: {$email}");
                return;
            }

            //Not include symbols,spaces
            $password = \Str::password(16, true, true, false, false);

            $data = [
                'email' => $email,
                'password' => $password,
                'first_name' => $firstName,
                'last_name' => $lastName
            ];

            $user = $this->userRepository->create($data);

            if ($user) {
                $params = json_decode(json_encode(["filter" => ["field" => "system_name"]]));
                $role = $this->roleRepository->getItem("super-admin", $params);
                if (!empty($role)) {
                    $user->roles()->attach($role->id);
                }
            }

            $this->info("✅ User Created");
            $this->line("Name: {$firstName} {$lastName}");
            $this->line("Email: {$email}");
            $this->line("Password: {$password}");
            $this->line(str_repeat('-', 40));
            $this->warn("⚠️ Important: Save your password in a secure place. It will not be retrievable again.");
        } else {
            $this->warn("-> User with email: {$email} already exists!");
        }
    }
}
