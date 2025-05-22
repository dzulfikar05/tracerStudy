<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                'name' => 'PT Teknologi Nusantara',
                'company_type' => 'private_company',
                'scope' => 'national',
                'address' => 'Jl. Merdeka No.123, Jakarta',
                'phone' => '08123456789',
            ],
            [
                'name' => 'Badan Riset Nasional',
                'company_type' => 'government_agency',
                'scope' => 'national',
                'address' => 'Jl. Gatot Subroto, Jakarta',
                'phone' => '021-654321',
            ],
            [
                'name' => 'Bank Rakyat Indonesia (BRI)',
                'company_type' => 'state-owned_enterprise',
                'scope' => 'international',
                'address' => 'Jl. Jendral Sudirman, Jakarta',
                'phone' => '14017',
            ],
            [
                'name' => 'PT Solusi Digital',
                'company_type' => 'private_company',
                'scope' => 'businessman',
                'address' => 'Jl. Cendana No. 7, Bandung',
                'phone' => '022-7891011',
            ],
        ];

        Company::insert($data);
    }
}
