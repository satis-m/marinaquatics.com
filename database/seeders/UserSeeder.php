<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Client;
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
        //developer user create
        $admin = Admin::create([
            'first_name' => 'satish',
            'last_name' => 'maharjan',
            'contact' => '0934234235',
            'gender' => 'Male',
            'email' => 'developer@user.com',
            'password' => 'password',
        ]);

        $admin->assignRole('admin');
        //        client user create
        $client = Client::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'gender' => 'Male',
            'contact' => '0934234235',
            'email' => 'client@user.com',
            'password' => 'password',
        ]);
        $client->assignRole('client');
    }
}
