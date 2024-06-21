<?php

namespace App\Traits;

trait ConsoleColors
{
    protected const CONSOLE_COLOR = [
        'Default' => "\e[39m",
        'Black' => "\e[30m",
        'Red' => "\e[31m",
        'Green' => "\e[32m",
        'Yellow' => "\e[33m",
        'Blue' => "\e[34m",
        'Magenta' => "\e[35m",
        'Cyan' => "\e[36m",
        'Light gray' => "\e[37m",
        'Dark gray' => "\e[90m",
        'Light red' => "\e[91m",
        'Light green' => "\e[92m",
        'Light yellow' => "\e[93m",
        'Light blue' => "\e[94m",
        'Light magenta' => "\e[95m",
        'Light cyan' => "\e[96m",
        'White' => "\e[97m",
        'Italic' => "\e[3m",
        'Regular' => "\e[0m",
    ];
}