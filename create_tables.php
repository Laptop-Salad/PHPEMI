<?php

require_once 'bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Models\Snippet;

Capsule::schema()->create('snippets', function (Blueprint $table) {
    $table->increments('id');
    $table->text('path');
    $table->text('output');
    $table->timestamps();
});


Capsule::schema()->create('modifications', function (Blueprint $table) {
    $table->increments('id');
    $table->foreignIdFor(Snippet::class);
    $table->text('path');
    $table->text('output');
    $table->boolean('passed');
    $table->timestamps();
});
