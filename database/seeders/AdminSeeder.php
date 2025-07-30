<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'id' => Str::uuid(),
            'name' => 'Admin Utama',
            'username' => 'admin',
            'phone' => '08123456789',
            'email' => 'admin@aksamedia.com',
            'password' => Hash::make('pastibisa'),
        ]);
    }
}
