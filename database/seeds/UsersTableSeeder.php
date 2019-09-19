<?php

use App\User;
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
        User::truncate();
        
        factory(User::class)
            ->create([
                'name' => 'rainskiss',
                'email'=> 'rainskiss@nate.com'
            ]);
    }
}
