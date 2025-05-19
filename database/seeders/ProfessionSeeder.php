<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfessionCategory;
use App\Models\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Infokom' => [
                'Software Engineer',
                'Data Analyst',
                'Administrator Jaringan',
                'Teknisi Keamanan Siber',
                'Staff IT',
                'Product Quality Assurance',
                'Digital Marketing',
                'Pengajar TI',
                'Wirausaha TI',
                'Customer Service TI',
            ],
            'Non Infokom' => [
                'Dokter',
                'Akuntan',
                'Guru',
                'Pengacara',
                'Perawat',
                'Wirausaha Umum',
                'Pegawai Negeri Sipil',
                'Manajer SDM',
                'Analis Keuangan',
                'Arsitek',
            ],
        ];

        foreach ($data as $categoryName => $professions) {
            $category = ProfessionCategory::where('name', $categoryName)->first();

            if (!$category) {
                echo "Kategori '$categoryName' tidak ditemukan.\n";
                continue;
            }

            foreach ($professions as $professionName) {
                Profession::firstOrCreate([
                    'profession_category_id' => $category->id,
                    'name' => $professionName,
                ]);
            }
        }
    }
}
