<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            [
                'name' => 'sunuvente.com',
                'email' => 'FSS@mail.com',
                'password' => bcrypt('sunuvente.com'),
                'foto' => 'logo-20240118140040.png',
                'level' => 1
            ],
            [
                'name' => 'Fatoufall',
                'email' => 'fatoufall17@mail.com',
                'password' => bcrypt('sunuventeexpress.com'),
                'foto' => 'logo-20240118140040.png',
                'level' => 2
            ]
        );

        array_map(function (array $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }, $users);
    }
}
