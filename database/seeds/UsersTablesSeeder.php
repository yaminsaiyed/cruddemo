<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;
class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          User::create([
            'firstname'    => 'Yamin',
            'lastname'    => 'Saiyed',
            'username'    => 'admin',
            'mobile'    => '8000074945',
            'email'    => 'saiyedyamin@gmail.com',
            'role_id'    => 1,
            'status'    => 1,
            'password'   =>  Hash::make('123456'),
            'remember_token' =>  "",
        ]);
            User::create([
            'firstname'    => 'Nada',
            'lastname'    => 'Saiyed',
            'username'    => 'sub_admin',
            'mobile'    => '1234567890',
            'email'    => 'ssaiyedyamin@gmail.com',
            'role_id'    => 2,
            'status'    => 1,
            'password'   =>  Hash::make('123456'),
            'remember_token' =>  "",
        ]);
    }
}
