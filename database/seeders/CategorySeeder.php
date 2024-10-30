<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Study',
                'color' => '#dc06ff',
            ],
            [
                'title' => 'Food',
                'color' => '#06c3ff',
            ],
            [
                'title' => 'Transport',
                'color' => '#ff9500',
            ],
            [
                'title' => 'Health',
                'color' => '#00ff47',
            ],
            [
                'title' => 'Entertainment',
                'color' => '#ff004c',
            ],
        ];

        $userId = User::first()->id;

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['title' => $category['title'], 'user_id' => $userId],
                ['color' => $category['color'], 'user_id' => $userId]
            );
        }

        $this->command->info('Categories seeded successfully!');
    }
}
