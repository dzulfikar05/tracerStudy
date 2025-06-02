<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil seeder yang diinginkan
        $this->call([
            UserSeeder::class,
            CompanySeeder::class,
            CategoryProfessionSeeder::class,
            ProfessionSeeder::class,
            QuestionnaireSeeder::class,
            QuestionSeeder::class,
            ContentSeeder::class,
            SuperiorSeeder::class,
            AlumniSeeder::class,
            AnswerSeeder::class
        ]);

    }
}
