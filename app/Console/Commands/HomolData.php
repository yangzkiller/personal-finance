<?php

namespace App\Console\Commands;

use App\Traits\ConsoleColors;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class HomolData extends Command
{
    use ConsoleColors;

    private const MIGRATIONS_PATH = 'database'.DIRECTORY_SEPARATOR.'migrations';
    private const SEEDER_ORDER = [
        'Database\Seeders\Testing\UserSeeder',
        'Database\Seeders\Testing\CategorySeeder',
        'Database\Seeders\Testing\TransactionSeeder'
    ];

    protected $signature = 'app:homol-data';
    protected $description = 'Resets all data from the database and seeds it with example values';

    public function handle(): void
    {
        if (!$this->checkMigrationNumbers()) return;
        $starting_time = microtime(true);
        print(self::CONSOLE_COLOR['Light blue']."-- Starting data reset\n");
        $this->wipe();
        $this->clearStorage();
        $this->migrate();
        $this->seed();
        print(self::CONSOLE_COLOR['Light blue']."-- Finished in ".round((microtime(true)-$starting_time), 2)." sec\n");
        print(self::CONSOLE_COLOR['Default']."\n* Use ".self::CONSOLE_COLOR['Italic']."php artisan create:migration".self::CONSOLE_COLOR['Regular']." to create new migrations.\n");
        print(self::CONSOLE_COLOR['Default']."* Use ".self::CONSOLE_COLOR['Italic']."php artisan update:structure".self::CONSOLE_COLOR['Regular']." to run new migrations.\n");
        print(self::CONSOLE_COLOR['Default']);
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

    /**
     * Searchs all migration files inside MIGRATIONS_PATH in subfolders
     */
    private function migrate(): void
    {
        $paths = glob(self::MIGRATIONS_PATH.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'*.php');

        $file_names = collect($paths)->map(function ($item) {
            return collect(explode(DIRECTORY_SEPARATOR, $item))->last();
        })->sort();

        foreach ($file_names as $file_name)
        {
            $migration_path = glob(self::MIGRATIONS_PATH.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.$file_name)[0];
            $wout_number = explode('_', $file_name, 2)[1]; // The file name without numbers
            $this->artisanCommand("migrate", ['--path' => $migration_path], self::CONSOLE_COLOR['Light yellow']."Migrated $wout_number");
        }
    }

    /**
     * Searchs all seeders files inside SEEDERS_PATH
     */
    private function seed(): void
    {
        foreach (self::SEEDER_ORDER as $seeder)
        {
            $this->artisanCommand("db:seed", ['--class' => $seeder], self::CONSOLE_COLOR['Light green']."Seeded $seeder");
        }
    }

    /**
     * Destroy all database tables
     */
    private function wipe(): void
    {
        $this->artisanCommand("db:wipe", [], self::CONSOLE_COLOR['Light red']."All tables destroyed");
    }

    /**
     * Removes all stored files
     */
    private function clearStorage(): void
    {
        $microtime = microtime(true);

        $documents_directory = storage_path('app/documents');
        $files = File::glob($documents_directory . '/*');
        foreach ($files as $file)
        {
            if ($file == $documents_directory . '/.gitignore') continue;
            File::delete($file);
        }
        $time_diff = round((microtime(true) - $microtime)*1000, 2);
        print(self::CONSOLE_COLOR['Light red']."All documents removed" . self::CONSOLE_COLOR['Dark gray']." (".$time_diff." ms)\n");
        
    }

    private function artisanCommand(string $command, array $parameters = [], string $message = '', bool $time = true): void
    {
        $microtime = microtime(true);

        Artisan::call($command, $parameters);
        $final_message = "";
        if ($message != '') { $final_message = $message; } else { $final_message = "Executed: $command"; }
        if ($time)
        {
            $time_diff = round((microtime(true) - $microtime)*1000, 2);
            $final_message .= self::CONSOLE_COLOR['Dark gray']." (".$time_diff." ms)";
        }
        $final_message .= "\n";
        print($final_message);
    }
}
