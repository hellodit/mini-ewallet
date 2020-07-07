<?php

use Illuminate\Database\Seeder;
use App\User; 
use App\UserBalance;
use App\UserBalanceHistory; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 3; $i++) { 
            $user = User::create([
                'name' => 'user '.$i, 
                'username' => 'user'.$i,
                'email'=> 'user'.$i.'@mail.com',
                'password' => bcrypt('dummy'),
            ]);

            $balance = UserBalance::create([
                'user_id' => $user->id, 
                'balance' => 10000,
                'balance_achieve' => 10000,
            ]);

            UserBalanceHistory::create([
                'user_balance_id' => $balance->id, 
                'balance_after' => 10000,
                'balance_before' => 0, 
                'activity' => 'initial balance',
                'type' => 'debit',
                'author' => 'system'
            ]);
        }
    }
}
