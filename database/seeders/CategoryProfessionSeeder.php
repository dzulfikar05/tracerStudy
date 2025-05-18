<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'Pengembangan Perangkat Lunak',        
            'Analisis Data / Data Science',        
            'Jaringan dan Keamanan Siber',         
            'Dukungan Teknis / Infrastruktur TI',
            'Manajemen Produk & Kualitas', 
            'Pemasaran & Bisnis Digital',        
            'Pendidikan dan Pelatihan TI',         
            'Wirausaha di Bidang TI',       
            'Pelayanan & Operasional TI', 
        ];

        foreach ($categories as $categoryName) {
            ProfessionCategory::create([
                'name' => $categoryName
            ]);
        }
    }
}
