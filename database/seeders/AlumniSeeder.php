<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Company;
use App\Models\Profession;
use App\Models\Superior;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::pluck('id')->toArray();
        $professions = Profession::pluck('id')->toArray();
        $superiors = Superior::pluck('id')->toArray();

        $data = [
            [
                'study_program' => 'D4 Teknik Informatika',
                'nim' => '0000000001',
                'full_name' => 'Rizky Pratama',
            ],
            [
                'study_program' => 'D4 Sistem Informasi Bisnis',
                'nim' => '0000000002',
                'full_name' => 'Putri Ayu Lestari',
            ],
            [
                'study_program' => 'D2 PPLS',
                'nim' => '0000000003',
                'full_name' => 'Dimas Aditya',
            ],
            [
                'study_program' => 'S2 MRTI',
                'nim' => '0000000004',
                'full_name' => 'Siti Nurhaliza',
            ],
            [
                'study_program' => 'S2 MRTI',
                'nim' => '0000000005',
                'full_name' => 'Budi Santoso',
            ],
            [
                'study_program' => 'D4 Teknik Informatika',
                'nim' => '0000000006',
                'full_name' => 'Lina Marlina',
            ],
            [
                'study_program' => 'D4 Teknik Informatika',
                'nim' => '0000000007',
                'full_name' => 'Andi Firmansyah',
            ],
            [
                'study_program' => 'D4 Teknik Informatika',
                'nim' => '0000000008',
                'full_name' => 'Nadia Kusuma',
            ],
            [
                'study_program' => 'D4 Sistem Informasi Bisnis',
                'nim' => '0000000009',
                'full_name' => 'Fajar Nugroho',
            ],
            [
                'study_program' => 'D4 Sistem Informasi Bisnis',
                'nim' => '0000000010',
                'full_name' => 'Rina Oktaviani',
            ],
            [
                'study_program' => 'D4 Sistem Informasi Bisnis',
                'nim' => '0000000011',
                'full_name' => 'Teguh Rahman',
            ],
            [
                'study_program' => 'D2 PPLS',
                'nim' => '0000000012',
                'full_name' => 'Yulia Anggraini',
            ],
        ];

        foreach ($data as $i => &$row) {
            $graduationDate = now();
            $startWorkDate = now()->subMonths(rand(1, 12));

            $row['graduation_date'] = $graduationDate->format('Y-m-d');
            $row['start_work_date'] = $startWorkDate->format('Y-m-d');
            $row['waiting_time'] = $this->getWaitingTime($graduationDate, $startWorkDate);

            $row['start_work_now_date'] = now()->format('Y-m-d');
            $row['phone'] = '0812345678' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $row['email'] = 'alumni' . ($i + 1) . '@example.com';
            $row['study_start_year'] = '20' . rand(16, 21);
            $row['company_id'] = $companies[array_rand($companies)] ?? null;
            $row['profession_id'] = $professions[array_rand($professions)] ?? null;
            $row['superior_id'] = $superiors[array_rand($superiors)] ?? null;
        }

        Alumni::insert($data);
    }

    protected function getWaitingTime($graduationDate, $startWorkDate): string
    {
        $graduation = Carbon::parse($graduationDate);
        $startWork = Carbon::parse($startWorkDate);
        $diffInDays = $graduation->diffInDays($startWork);
        $monthFloat = round($diffInDays / 30.44, 1);
        return number_format($monthFloat, 1, ',', '');
    }
}
