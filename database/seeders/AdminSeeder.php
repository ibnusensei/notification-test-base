<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name'      => 'Administrator',
            'email'     => 'admin@gmail.com',
            'password'  => Hash::make('admin123'),
        ];

        $user = User::create($data);
        $user->assignRole('admin');
    }
}
