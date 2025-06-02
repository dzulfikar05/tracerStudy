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
                'is_assessment' => false
            ],
            [
                'questionnaire_id' => 1,
                'type' => 'choice',
                'question' => 'Berapa Gaji anda',
                'options' => json_encode(["<3 Juta", "3 juta sampai < 5 juta", "5 juta sampai < 10 juta", "> 10 juta"]),
                'is_assessment' => false
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question' => 'Kerjasama Tim',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
                'is_assessment' => true
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question' => 'Keahlian di bidang IT',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
                'is_assessment' => true
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question' => 'Kemampuan bahasa asing (Inggris)',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
                'is_assessment' => true
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question' => 'Kemampuan berkomunikasi',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
                'is_assessment' => true
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question' => 'Pengembangan diri',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
                'is_assessment' => true
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question' => 'Kepemimpinan',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
                'is_assessment' => true
            ],
            [
                'questionnaire_id' => 2,
                'type' => 'choice',
                'question' => 'Etos Kerja',
                'options' => json_encode(["Sangat Baik", "Baik", "Cukup", "Kurang"]),
                'is_assessment' => true
            ],
        ];

        Question::insert($data);
    }
}
