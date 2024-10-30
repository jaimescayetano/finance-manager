<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(IncomeSourceSeeder::class);
        $this->call(IncomeSeeder::class);
        $this->call(SavingSeeder::class);
        $this->call(ExpenseSeeder::class);
    }
}
