<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Question;
use App\Models\Questionnaire;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                'questionnaire_id' => 1,
                'type' => 'essay',
                'question' => 'Apa kesulitan yang anda alami pada saat masa pengenalan kerja',
                'options' => null,
            ],
            [
                'questionnaire_id' => 1,
                'type' => 'choice',
                'question' => 'Berapa Gaji anda',
                'options' => json_encode(["<3 Juta", "3 juta sampai < 5 juta", "5 juta sampai < 10 juta", "> 10 juta"]),
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question' => 'Kedisiplinan',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question' => 'Kebersihan',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question' => 'Kemampuan bermanuver dalam tekanan',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
            ],
        ];

        Question::insert($data);
    }
}
