<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;
class RolesTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	DB::table('roles')->insert([
		 ['name' => 'Admin'],
		 ['name' => 'Sub Admin'],
		]);
    }
}
