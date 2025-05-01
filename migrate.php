<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Models\Migration;

require_once "vendor/autoload.php";
require_once "bootstrap.php";

$migrations = scandir("migrations");

foreach ($migrations as $migration_name) {
    // we have already ran this migration, skip
    if (Capsule::schema()->hasTable('migrations') && Migration::where('name', $migration_name)->first()) {continue;}

    echo "{$migration_name}\n";

    $full_path = "migrations/{$migration_name}";

    shell_exec("php {$full_path}");

    if (Capsule::schema()->hasTable('migrations')) {
        Migration::create([
            'name' => $migration_name,
        ]);
    }
}