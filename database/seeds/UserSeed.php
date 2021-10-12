<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'first_name' => 'Admin', 'email' => 'admin@admin.com', 'password' => bcrypt('1'), 'role_id' => 1, 'remember_token' => '',],

        ];

        foreach ($items as $item) {
            \App\Models\User::create($item);
        }
    }
}
