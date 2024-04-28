<?php

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = require __DIR__ . '/src/config/app.php';

$capsule = new Capsule();

$capsule->addConnection($config['database']);

$capsule->setAsGlobal();
$capsule->bootEloquent();

if (!Capsule::schema()->hasTable('users')) {
    Capsule::schema()->create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrent();
    });

    Capsule::table('users')->insert([
        ['name' => 'test'],
        ['name' => 'test 2'],
        ['name' => 'test 3'],
    ]);
}

if (!Capsule::schema()->hasTable('groups')) {
    Capsule::schema()->create('groups', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrent();
    });
    Capsule::table('groups')->insert([
        ['name' => 'admin'],
        ['name' => 'moder'],
        ['name' => 'user'],
    ]);
}

if (!Capsule::schema()->hasTable('permissions')) {
    Capsule::schema()->create('permissions', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->useCurrent();
    });
    Capsule::table('permissions')->insert([
        ['name' => 'send_messages'],
        ['name' => 'service_api'],
        ['name' => 'debug'],
    ]);
}

if (!Capsule::schema()->hasTable('user_groups')) {
    Capsule::schema()->create('user_groups', function (Blueprint $table) {
        $table->integer('user_id')->unsigned();
        $table->integer('group_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
    });
}
if (!Capsule::schema()->hasTable('group_permissions')) {
    Capsule::schema()->create('group_permissions', function (Blueprint $table) {
        $table->integer('group_id')->unsigned();
        $table->integer('permission_id')->unsigned();
        $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
    });
}

if (!Capsule::schema()->hasTable('blocked_permissions')) {
    Capsule::schema()->create('blocked_permissions', function (Blueprint $table) {
        $table->integer('user_id')->unsigned();
        $table->integer('permission_id')->unsigned();

        $table->primary(['user_id', 'permission_id']);

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
    });
}


dump('ok');