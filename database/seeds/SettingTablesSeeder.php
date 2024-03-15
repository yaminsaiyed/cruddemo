<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Setting;

class SettingTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Setting::create([
            'company_name'    => 'Admin Panel',
            'company_phone'    => '8000074945',
            'company_email'    => 'saiyedyamin@gmail.com',
            'company_address'    => 'Lorem Ipsum,123456',
            'company_logo'    => "",
            'company_fav'    => "",
        ]);
    }
}
