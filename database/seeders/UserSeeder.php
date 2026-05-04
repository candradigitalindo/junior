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
        $roles = [
            'superadmin' => 'Superadmin',
            'loket'      => 'Loket',
            'kasir'      => 'Kasir',
            'pengecekan' => 'Pengecekan',
            'pengerjaan' => 'Pengerjaan',
            'gudang'     => 'Gudang',
        ];

        foreach ($roles as $username => $roleName) {
            $user = User::updateOrCreate(
                ['username' => $username],
                [
                    'name' => $roleName,
                    'password' => Hash::make('12345678')
                ]
            );

            Role::updateOrCreate(
                ['user_id' => $user->id],
                ['role' => $roleName]
            );
        }
    }
}
