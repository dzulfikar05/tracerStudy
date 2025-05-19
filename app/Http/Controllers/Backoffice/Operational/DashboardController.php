<?php

namespace App\Http\Controllers\Backoffice\Operational;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlumniRequest;
use App\Models\Alumni;
use App\Models\Company;
use App\Models\Profession;
use App\Models\ProfessionCategory;
use App\Models\Superior;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('layouts.index', [
            'title' => 'Dashboard',
            'content' => view('backoffice.dashboard.index')
        ]);
    }

    public function getChartProfession(Request $request)
    {
        $total = Alumni::count();

        $topProfessions = Alumni::select('profession_id', DB::raw('count(*) as total'))
            ->groupBy('profession_id')
            ->orderByDesc('total')
            ->take(10)
            ->with('profession')
            ->get();

        $topProfessionCount = $topProfessions->sum('total');

        $otherCount = $total - $topProfessionCount;

        $chartData = $topProfessions->map(function ($item) use ($total) {
            return [
                'label' => $item->profession->name ?? 'Tidak diketahui',
                'value' => round(($item->total / $total) * 100, 2)
            ];
        })->toArray();

        if ($otherCount > 0) {
            $chartData[] = [
                'label' => 'Lainnya',
                'value' => round(($otherCount / $total) * 100, 2)
            ];
        }

        return response()->json([
            'data' => $chartData
        ]);
    }

    public function getChartCompanyType(Request $request)
    {
        $companyTypeLabels = [
            'higher_education' => 'Perguruan Tinggi',
            'government_agency' => 'Instansi Pemerintah',
            'state-owned_enterprise' => 'Badan Usaha Milik Negara',
            'private_company' => 'Perusahaan Swasta',
        ];

        $rawData = Alumni::select(
            'companies.company_type',
            DB::raw('count(alumnis.id) as total')
        )
            ->join('companies', 'alumnis.company_id', '=', 'companies.id')
            ->groupBy('companies.company_type')
            ->pluck('total', 'companies.company_type');

        $totalAlumni = $rawData->sum();

        $data = collect($companyTypeLabels)->map(function ($label, $key) use ($rawData, $totalAlumni) {
            $count = $rawData[$key] ?? 0;
            $percentage = $totalAlumni > 0 ? round(($count / $totalAlumni) * 100, 2) : 0;

            return [
                'label' => $label,
                'value' => $percentage
            ];
        })->values();

        return response()->json([
            'data' => $data
        ]);
    }
}
