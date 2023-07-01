<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Staff;
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
        $staff = Staff::create([
            'first_name' => 'satish',
            'last_name' => 'maharjan',
            'contact' => '0934234235',
            'gender' => 'Male',
        ]);

        $user = $staff->account()->create([
            'email' => 'developer@user.com',
            'password' => 'password',
        ]);
        $user->assignRole('developer');
        //staff user create
        $staff = Staff::create([
            'first_name' => 'bishal',
            'last_name' => 'pradhan',
            'contact' => '0934234235',
            'gender' => 'Male',
        ]);

        $user = $staff->account()->create([
            'email' => 'admin@user.com',
            'password' => 'password',
        ]);
        $user->assignRole('developer');
        //client user create
        $sponsor = Client::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'gender' => 'Male',
            'contact' => '0934234235',
        ]);
        $user = $sponsor->account()->create([
            'email' => 'client@user.com',
            'password' => 'password',
        ]);
        $user->assignRole('client');
    }
}
