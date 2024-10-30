<?php

namespace Database\Seeders;

use App\Models\Saving;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SavingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $user = User::first();
        $balance = $user->balance;
        $savings = 0;

        Saving::withoutEvents(function () use ($faker, $user, $balance, $savings) {
            for ($i = 0; $i < 4; $i++) {
                $amount = $faker->randomFloat(2, 100, max: 200);

                if ($balance < $amount) continue;

                Saving::create([
                    'amount' => $amount,
                    'user_id' => $user->id,
                ]);

                $balance -= $amount;
                $savings += $amount;
            }

            $user->update(['balance' => $balance, 'savings' => $savings]);
        });
    }
}
