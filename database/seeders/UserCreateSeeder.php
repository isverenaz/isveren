<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCreateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Vacancy',
            'surname' => 'Test',
            'phone' => '0507027093',
            'email' => 'vacancy@email.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
