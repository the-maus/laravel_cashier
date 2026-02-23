<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($id=1; $id < 4; $id++) { 
            DB::table('users')->insert([
                'id'       => $id,
                'name'     => "User $id",
                'email'    => "user_$id@gmail.com",
                "password" => bcrypt("user$id"),
                "email_verified_at" => now(),
                "created_at" => now(),
            ]);
        }
    }
}
