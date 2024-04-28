<?php

namespace App\services;

use Illuminate\Database\Capsule\Manager as DB;

class UserService
{
    public function create($name): bool
    {
        return DB::table('users')->insert([
            'name' => $name,
        ]);
    }

    public function remove(array $id): int
    {
        return DB::table('users')->where($id)->delete();
    }

    public function all(): \Illuminate\Support\Collection
    {
        return DB::table('users')
            ->limit(100)
            ->get();
    }
}