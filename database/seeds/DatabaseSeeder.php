<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call(PermissionTableSeeder::class);
        $this->call(RolesTablesSeeder::class);
        $this->call(UsersTablesSeeder::class);
        $this->call(SettingTablesSeeder::class);
        $this->call(PermissionTableSeeder::class);
    }
}
