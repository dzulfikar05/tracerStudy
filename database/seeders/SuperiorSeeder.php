<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Superior;

class SuperiorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();

      $full_names = [
            'Prasetyo Budiatma',
            'Ridho Pratama',
            'Rahmat Hidayat',
            'Rizky Maulana Putra',
            'Aditya Nugraha',
            'Ramadhan Jaya',
            'Setiawan Putra',
            'Akbar Sanjaya',
            'Ananda Putri',
            'Permana Sidiq',
            'Nur Cahyo',
            'Adi Saputra',
            'Fahreza Aulia',
            'Dwi Santoso',
            'Wahyu Utomo',
            'Bayu Prakoso',
        ];
        foreach ($companies as $index => $company) {
            Superior::create([
                'full_name' => $full_names[$index],
                'position' => 'Manager Divisi ' . ($index + 1),
                'phone' => '0812345678' . str_pad($index, 2, '0', STR_PAD_LEFT),
                'email' => 'dzulfikar0456@gmail.com',
                'company_id' => $company->id,
            ]);
        }
    }
}
