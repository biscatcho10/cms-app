
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->where('email' , 'karimbiscatcho@gmail.com')->first();
        if(! $user){
            User::create([
                'name' => 'karim osama',
                'email' => 'karimbiscatcho@gmail.com',
                'password' => Hash::make('11111111'),
                'role' => 'admin'
            ]);
        }
    }
}

