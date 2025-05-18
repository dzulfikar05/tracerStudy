<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'Pengembangan Perangkat Lunak'         => ['Software Engineer'],
            'Analisis Data / Data Science'         => ['Data Analyst'],
            'Jaringan dan Keamanan Siber'          => ['Administrator', 'Teknisi'],
            'Dukungan Teknis / Infrastruktur TI'   => ['Staff IT'],
            'Manajemen Produk & Kualitas'          => ['Product Quality Assurance'],
            'Pemasaran & Bisnis Digital'           => ['Marketing'],
            'Pendidikan dan Pelatihan TI'          => ['Pengajar'],
            'Wirausaha di Bidang TI'               => ['Pemilik Usaha'],
            'Pelayanan & Operasional TI'           => ['Customer Service'],
        ];

        foreach ($data as $categoryName => $professions) {
            $category = ProfessionCategory::where('name', $categoryName)->first();

            if ($category) {
                foreach ($professions as $professionName) {
                    Profession::create([
                        'profession_category_id' => $category->id,
                        'name' => $professionName,
                    ]);
                }
            } else {
                // Optional: log jika kategori tidak ditemukan
                echo "Kategori '$categoryName' tidak ditemukan di database.\n";
            }
        }
    }
}
