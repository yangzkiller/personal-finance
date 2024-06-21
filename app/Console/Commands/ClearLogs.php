<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearLogs extends Command
{
    protected $signature = 'logs:clear';
    protected $description = 'Clear application logs usage: php artisan logs:clear';

    public function handle()
    {
        $logDirectory = storage_path('logs');
        $files = File::glob($logDirectory . '/*.log');
        
        foreach ($files as $file) 
        {
            file_put_contents($file, '');
        }

        $this->info('Logs have been cleared!');
    }
}