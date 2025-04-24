<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@accf.in',
            'role' => 9,
            'unit' => 'HO', 
            'password' => Hash::make('Password@123'),
        ]);

        factory(App\User::class, 50)->create();
        
    }
}
