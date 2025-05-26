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
                'question_text' => 'Apa kesulitan yang anda alami pada saat masa pengenalan kerja',
                'options' => null,
                'is_active' => false,
            ],
            [
                'questionnaire_id' => 1,
                'type' => 'choice',
                'question_text' => 'Berapa Gaji anda',
                'options' => json_encode(["<3 Juta", "3 juta sampai < 5 juta", "5 juta sampai < 10 juta", "> 10 juta"]),
                'is_active' => false,
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question_text' => 'Kedisiplinan',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
                'is_active' => true,
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question_text' => 'Kebersihan',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
                'is_active' => true,
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question_text' => 'Kemampuan bermanuver dalam tekanan',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
                'is_active' => true,
            ],
        ];

        Question::insert($data);
    }
}
