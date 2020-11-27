<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $userRole = Role::where('name', 'user')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $ownerRole = Role::where('name', 'owner')->first();

        $user = User::create([
            'name' => 'Generic User',
            'email' => 'user@user.com',
            'password' => Hash::make('password')
        ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        $owner = User::create([
            'name' => 'Owner User',
            'email' => 'owner@owner.com',
            'password' => Hash::make('password')
        ]);

        $user->roles()->attach($userRole);
        $admin->roles()->attach($adminRole);
        $owner->roles()->attach($ownerRole);

    }
}
