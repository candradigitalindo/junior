<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cek = User::first();
        if ($cek) {
            $cek->delete();
            $cek->role->delete();
            $user = User::create([
                'name' => 'Superadmin',
                // 'phone' => '0812345678',
                'username'  => 'superadmin',
                'password' => Hash::make('12345678')
            ]);

            Role::create([
                'user_id' => $user->id,
                'role'      => 'Superadmin'
            ]);
        }

        $user = User::create([
            'name' => 'Superadmin',
            // 'phone' => '0812345678',
            'username'  => 'superadmin',
            'password' => Hash::make('12345678')
        ]);

        Role::create([
            'user_id' => $user->id,
            'role'      => 'Superadmin'
        ]);
    }
}
