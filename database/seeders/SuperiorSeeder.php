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

        foreach ($companies as $index => $company) {
            Superior::create([
                'full_name' => 'Atasan ' . ($index + 1),
                'position' => 'Manager Divisi ' . ($index + 1),
                'phone' => '0812345678' . str_pad($index, 2, '0', STR_PAD_LEFT),
                'email' => 'dzulfikar0456@gmail.com',
                'company_id' => $company->id,
            ]);
        }
    }
}
