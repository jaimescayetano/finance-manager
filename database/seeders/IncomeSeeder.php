<?php

namespace Database\Seeders;

use App\Models\Income;
use App\Models\IncomeSource;
use App\Models\User;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $user = User::first();
        $balance = 0;
        $incomeSourceIds = IncomeSource::pluck('id')->toArray();

        Income::withoutEvents(function () use ($faker, $user, $incomeSourceIds, $balance) {
            for ($monthsAgo = 1; $monthsAgo <= 8; $monthsAgo++) {
                $numberOfIncomes = rand(1, 3);

                for ($i = 0; $i < $numberOfIncomes; $i++) {
                    $amount = $faker->randomFloat(2, 100, 1000);
                    Income::create([
                        'amount' => $amount,
                        'date' => (new DateTime())->modify("-{$monthsAgo} months")->format('Y-m-d'),
                        'income_source_id' => $faker->randomElement($incomeSourceIds),
                        'user_id' => $user->id,
                    ]);

                    $balance += $amount;
                }
            }

            $user->update(['balance' => $balance]);
        });
    }
}
