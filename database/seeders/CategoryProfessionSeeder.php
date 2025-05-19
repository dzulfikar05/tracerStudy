<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfessionCategory;

class CategoryProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Infokom',
            'Non Infokom',
        ];

        foreach ($categories as $categoryName) {
            ProfessionCategory::firstOrCreate([
                'name' => $categoryName
            ]);
        }
    }
}
