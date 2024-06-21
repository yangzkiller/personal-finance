<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;

class CreateEnum extends Command
{
    protected $signature = 'create:enum {EnumName}';
    protected $description = 'Creates an Enumeration Class.\nUsage: php artisan create:enum [EnumName]';

    public function handle()
    {
        $enum = $this->argument('EnumName');

        $enumClass = ucwords(Pluralizer::plural($enum));
        $filepath = 'app/Enums/'.$enum.'.php';
        if (file_exists($filepath)) { return print('Enum '.$enum.' already exists.'); }
        copy('stubs/enum.stub', $filepath);
        $file = fopen($filepath, 'r');
        $file_content = fread($file, filesize($filepath));
        $file_content = str_replace("{{ namespace }}", "App\\Enums", $file_content);
        $file_content = str_replace("{{ class }}", $enumClass, $file_content);
        fclose($file);
        $file = fopen($filepath, 'w');
        fwrite($file, $file_content);
        fclose($file);
    }

    protected function promptForMissingArgumentsUsing()
    {
        return [
            'EnumName' => ['What is the Enum name?', 'E.g. Roles'],
        ];
    }
}
