<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'Mohamed Gohar', 'user_name' => 'mohamedgohar', 'phone' => '01099371188', 'email' => 'mohamedgohar365@gmail.com', 'password' => bcrypt('password')],
            ['name' => 'Admin Admin', 'user_name' => 'admin', 'phone' => '01000500900', 'email' => 'admin@admin.com', 'password' => bcrypt('password')],
            ['name' => 'Client Client', 'user_name' => 'client', 'phone' => '01100005555', 'email' => 'client@client.com', 'password' => bcrypt('password')],
            ['name' => 'user', 'user_name' => 'user', 'phone' => '01100666335', 'email' => 'user@user.com', 'password' => bcrypt('password')],
        ];

        $roles = ['Admin', 'Admin', 'Client', 'Client'];
        foreach ($users as $index => $user) {
            $user = User::create($user);
            $user->assignRole($roles[$index]);
        }

    }
}
