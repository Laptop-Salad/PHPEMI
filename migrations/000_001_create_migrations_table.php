<?php

require_once 'bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

Capsule::schema()->create('migrations', function (Blueprint $table) {
    $table->increments('id');
    $table->text('name');
    $table->timestamps();
});