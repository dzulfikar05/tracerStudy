<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Questionnaire;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                // 'period_year' => 2025,
                'type' => 'alumni',
                'title' => 'Kuisioner Lulusan JTI',
                'description' => 'ini adalah kuisioner lulusan JTI Polinema',
                'is_active' => true,
                'is_dashboard' => false,
            ],
            [
                // 'period_year' => 2023,
                'type' => 'superior',
                'title' => 'Kuisioner Pengguna Lulusan JTI Polinema',
                'description' => 'ini adalah kuisioner untuk pengguna lulusan jti polinema',
                'is_active' => true,
                'is_dashboard' => true,
            ],
        ];

        Questionnaire::insert($data);
    }
}
