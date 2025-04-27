<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $user = new User([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'user_code' => 'A0001',
            'name' => 'Admin Laundry',
            'phone_number' => '081383004378',
            'role' => Role::Admin->value,
        ]);
        $user->save();
        $user2 = new User([
            'email' => 'member@gmail.com',
            'password' => Hash::make('member123'),
            'user_code' => 'M0001',
            'name' => 'Member',
            'phone_number' => '08974835297',
            'role' => Role::Member->value,
        ]);
        $user2->save();
    }
}
