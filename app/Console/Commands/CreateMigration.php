<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Artisan;
use App\Traits\ConsoleColors;

class CreateMigration extends Command implements PromptsForMissingInput
{
    use ConsoleColors;

    private const MIGRATIONS_PATH = 'database'.DIRECTORY_SEPARATOR.'migrations';
    protected $signature = 'create:migration {folder} {migration_name}';
    protected $description = "Creates a new migration in this project's format.\nUsage: php artisan create:migration [FolderName] [migration_name]";

    public function handle()
    {
        if (!$this->checkMigrationNumbers()) return;
        $folder = $this->argument('folder');
        $migration_name = $this->argument('migration_name');

        if (!is_dir('database/migrations/'.$folder)) { return print('Folder does not exist'); }
        if (count(glob('database/migrations/'.$folder.'/*'.$migration_name.'.php'))) { return print('Migration already exists in that folder'); }

        Artisan::call("make:migration ".$migration_name);
        $original_file_name = glob('database/migrations/*'.$migration_name.'.php');
        if (count($original_file_name) != 1) { return print('Something went wrong. Is there only one migration on database/migrations/? It must be.'); }

        $migration_number = str_pad($this->getLastMigrationNumber()+1, 6, '0', STR_PAD_LEFT);
        rename($original_file_name[0], 'database/migrations/'.$folder.'/'.$migration_number.'_'.$migration_name.'.php');
    }

    /**
     * Checks if there are migrations with the same number
     */
    private function checkMigrationNumbers(): bool
    {
        $paths = glob(self::MIGRATIONS_PATH.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'*.php');
        $numbers = [];
        foreach ($paths as $path)
        {
            $file_name = collect(explode(DIRECTORY_SEPARATOR, $path))->last();
            $number = explode('_', $file_name, 2)[0];
            if (in_array($number, $numbers))
            {
                print(self::CONSOLE_COLOR['Light red']."Error: There are migrations with the same number ($number)\n");
                return false;
            }
            $numbers[] = $number;
        }
        return true;
    }

    private function getLastMigrationNumber(): int
    {
        $migrations_paths = collect(glob('database/migrations/*/*.php'));
        $migrations_names = $migrations_paths->map(function ($migration_path) { return explode('/', $migration_path)[3]; });
        $migrations_numbers = $migrations_names->map(function ($migration_name) { return explode('_', $migration_name)[0]; });
        return max($migrations_numbers->toArray());
    }

    protected function promptForMissingArgumentsUsing()
    {
        return [
            'folder' => ['Which folder will this migration be inputed?', 'E.g. Solicitations'],
            'migration_name' => ['What is the name of the migration?', 'E.g. create_solicitations_table'],
        ];
    }
}
