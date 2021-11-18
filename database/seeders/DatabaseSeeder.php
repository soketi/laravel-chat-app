<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(['email' => 'test@test.com']);
        User::factory()->create(['email' => 'test2@test.com']);
        User::factory()->create(['email' => 'test3@test.com']);
    }
}
