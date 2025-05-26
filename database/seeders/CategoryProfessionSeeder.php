<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Seeder;
use App\Models\ProfessionCategory;

class CategoryProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Infokom'],
            ['name' => 'Non Infokom'],
        ];

        ProfessionCategory::insert($data);
    }
}
