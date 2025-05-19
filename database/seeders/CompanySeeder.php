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
        Company::create([
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
            'scope' => 'local',
            'address' => 'Jl. Cendana No. 7, Bandung',
            'phone' => '022-7891011',
        ],
        [
            'name' => 'Politeknik Negeri Malang',
            'company_type' => 'higher_education',
            'scope' => 'national',
            'address' => 'Jl. Soekarno-Hatta No.9, Malang',
            'phone' => '0341-404424',
        ],
        [
            'name' => 'Dinas Kominfo Surabaya',
            'company_type' => 'government_agency',
            'scope' => 'local',
            'address' => 'Jl. Jimerto No.25-27, Surabaya',
            'phone' => '031-5343000',
        ],
        [
            'name' => 'PT Global Mediatek',
            'company_type' => 'private_company',
            'scope' => 'international',
            'address' => 'Jl. Asia Afrika, Jakarta',
            'phone' => '0811223344',
        ],
        [
            'name' => 'Perusahaan Listrik Negara (PLN)',
            'company_type' => 'state-owned_enterprise',
            'scope' => 'national',
            'address' => 'Jl. Trunojoyo, Jakarta',
            'phone' => '123',
        ],
        [
            'name' => 'Bappenas',
            'company_type' => 'government_agency',
            'scope' => 'national',
            'address' => 'Jl. Taman Suropati No.2, Jakarta',
            'phone' => '021-31928280',
        ],
        [
            'name' => 'PT Kreatif Digital',
            'company_type' => 'private_company',
            'scope' => 'local',
            'address' => 'Jl. Veteran No.1, Yogyakarta',
            'phone' => '0274-123456',
        ],
    
        );
    }
}