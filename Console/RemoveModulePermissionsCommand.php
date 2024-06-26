<?php

namespace Modules\User\Console;

use Illuminate\Console\Command;
use Modules\User\Permissions\PermissionsRemover;
use Symfony\Component\Console\Input\InputArgument;

class RemoveModulePermissionsCommand extends Command
{
    protected $name = 'asgard:user:remove-permissions';

    protected $description = 'Remove all the permissions for given module from any role or user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $module = $this->argument('module');

        (new PermissionsRemover($module))->removeAll();

        $this->info("All permissions for [$module] have been removed");
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [
            ['module', InputArgument::REQUIRED, 'Module name'],
        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
        ];
    }
}
