<?php

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
        factory('App\User')->create([
            'name' => 'rs',
            'email' => 'noreply@remotesyslog.com',
            'username' => 'rs'
        ]);
    }
}
