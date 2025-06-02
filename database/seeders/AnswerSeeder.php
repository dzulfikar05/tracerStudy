<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Alumni;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AnswerSeeder extends Seeder
{
    public function run(): void
    {
        $answers = [];

        // === 1. Alumni Answers (questionnaire_id: 1) ===
        foreach (Alumni::all() as $alumni) {
            // Essay answer
            $answers[] = [
                'filler_type' => 'alumni',
                'filler_id' => $alumni->id,
                'alumni_id' => $alumni->id,
                'questionnaire_id' => 1,
                'question_id' => 1,
                'answer' => 'Saya mengalami kesulitan adaptasi di tempat kerja.',
                'is_assessment' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Choice answer (Gaji)
            $salaryOptions = ["<3 Juta", "3 juta sampai < 5 juta", "5 juta sampai < 10 juta", "> 10 juta"];
            $answers[] = [
                'filler_type' => 'alumni',
                'filler_id' => $alumni->id,
                'alumni_id' => $alumni->id,
                'questionnaire_id' => 1,
                'question_id' => 2,
                'answer' => $salaryOptions[array_rand($salaryOptions)],
                'is_assessment' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $assessmentOptions = ["Sangat Baik", "Baik", "Cukup", "Kurang"];
        $questionIds = range(3, 9); // pertanyaan untuk superior

        foreach (Alumni::whereNotNull('superior_id')->get() as $alumni) {
            foreach ($questionIds as $questionId) {
                $answers[] = [
                    'filler_type' => 'superior',
                    'filler_id' => $alumni->superior_id,
                    'alumni_id' => $alumni->id,
                    'questionnaire_id' => 2,
                    'question_id' => $questionId,
                    'answer' => $assessmentOptions[array_rand($assessmentOptions)],
                    'is_assessment' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        Answer::insert($answers);
    }
}
