<?php

namespace Database\Seeders;

use App\Models\ApplicationInfo;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ApplicationInfoSeeder extends Seeder
{
    public function run()
    {
        ApplicationInfo::create([
            'title' => 'Marine Aquatics Nepal',
            'email' => 'admin@example.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'address' => 'address',
            'contact' => '0123456789',
        ]);
    }
}
