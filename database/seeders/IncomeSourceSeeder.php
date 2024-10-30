<?php

namespace Database\Seeders;

use App\Models\IncomeSource;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = User::first()->id;

        $incomeSources = [
            ['title' => 'Salary', 'user_id' => $userId],
            ['title' => 'Investments', 'user_id' => $userId],
            ['title' => 'Business', 'user_id' => $userId],
            ['title' => 'Gifts', 'user_id' => $userId],
            ['title' => 'Other', 'user_id' => $userId],
        ];

        foreach ($incomeSources as $source) {
            IncomeSource::create($source);
        }
    }
}
