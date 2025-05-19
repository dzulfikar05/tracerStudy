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
        $request->validate([
            'year_start' => 'nullable|integer',
            'year_end' => 'nullable|integer',
            'study_program' => 'nullable|string|max:255',
        ]);

        $currentYear = now()->year;
        $startYear = $request->year_start ?? $currentYear - 3;
        $endYear = $request->year_end ?? $currentYear;

        $alumnis = Alumni::query();

        if ($request->filled('year_start')) {
            $alumnis->whereYear('graduation_date', '>=', $startYear);
        }
        if ($request->filled('year_end')) {
            $alumnis->whereYear('graduation_date', '<=', $request->year_end);
        }
        if ($request->filled('study_program')) {
            $alumnis->where('study_program', $endYear);
        }

        $total = (clone $alumnis)->count();

        $topProfessions = (clone $alumnis)
            ->select('profession_id', DB::raw('count(*) as total'))
            ->groupBy('profession_id')
            ->orderByDesc('total')
            ->with('profession')
            ->take(10)
            ->get();

        $topProfessionCount = $topProfessions->sum('total');
        $otherCount = $total - $topProfessionCount;

        $chartData = $topProfessions->map(function ($item) use ($total) {
            return [
                'label' => optional($item->profession)->name ?? 'Tidak diketahui',
                'value' => round(($item->total / $total) * 100, 2)
            ];
        })->toArray();

        if ($otherCount > 0) {
            $chartData[] = [
                'label' => 'Lainnya',
                'value' => round(($otherCount / $total) * 100, 2)
            ];
        }

        return response()->json(['data' => $chartData]);
    }

    public function getChartCompanyType(Request $request)
    {
        $request->validate([
            'year_start' => 'nullable|integer',
            'year_end' => 'nullable|integer',
            'study_program' => 'nullable|string|max:255',
        ]);

        $currentYear = now()->year;
        $startYear = $request->year_start ?? $currentYear - 3;
        $endYear = $request->year_end ?? $currentYear;

        $alumnis = Alumni::query();

        if ($request->filled('year_start')) {
            $alumnis->whereYear('graduation_date', '>=', $startYear);
        }
        if ($request->filled('year_end')) {
            $alumnis->whereYear('graduation_date', '<=', $endYear);
        }
        if ($request->filled('study_program')) {
            $alumnis->where('study_program', $request->study_program);
        }

        $companyTypeLabels = [
            'higher_education' => 'Perguruan Tinggi',
            'government_agency' => 'Instansi Pemerintah',
            'state-owned_enterprise' => 'Badan Usaha Milik Negara',
            'private_company' => 'Perusahaan Swasta',
        ];

        $rawData = $alumnis
            ->join('companies', 'alumnis.company_id', '=', 'companies.id')
            ->select('companies.company_type', DB::raw('count(alumnis.id) as total'))
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

        return response()->json(['data' => $data]);
    }

    public function getTableProfession(Request $request)
    {
        $request->validate([
            'year_start' => 'nullable|integer',
            'year_end' => 'nullable|integer',
            'study_program' => 'nullable|string|max:255',
        ]);

        $currentYear = now()->year;
        $startYear = $request->year_start ?? $currentYear - 3;
        $endYear = $request->year_end ?? $currentYear;

        $years = collect(range($startYear, $endYear));
        $result = [];

        foreach ($years as $year) {
            $alumnis = Alumni::whereYear('graduation_date', $year);

            if ($request->filled('study_program')) {
                $alumnis->where('study_program', $request->study_program);
            }

            $count_alumni = (clone $alumnis)->count();
            $count_alumni_filled = (clone $alumnis)->whereNotNull('profession_id')->count();

            $infokom = (clone $alumnis)
                ->whereHas('profession.profession_category', function ($q) {
                    $q->where('name', 'Infokom');
                })->count();

            $non_infokom = (clone $alumnis)
                ->whereHas('profession.profession_category', function ($q) {
                    $q->where('name', 'Non Infokom');
                })->count();

            $multi = (clone $alumnis)
                ->whereHas('company', function ($q) {
                    $q->where('scope', 'international');
                })->count();

            $national = (clone $alumnis)
                ->whereHas('company', function ($q) {
                    $q->where('scope', 'national');
                })->count();

            $wirausaha = (clone $alumnis)
                ->whereHas('company', function ($q) {
                    $q->where('scope', 'local');
                })->count();

            $result[] = [
                'year' => $year,
                'count_alumni' => $count_alumni,
                'count_alumni_filled' => $count_alumni_filled,
                'infokom' => $infokom,
                'non_infokom' => $non_infokom,
                'multi' => $multi,
                'national' => $national,
                'wirausaha' => $wirausaha,
            ];
        }

        return response()->json(['data' => $result]);
    }

    public function getTableWaitingTime(Request $request)
    {
        $request->validate([
            'year_start' => 'nullable|integer',
            'year_end' => 'nullable|integer',
            'study_program' => 'nullable|string|max:255',
        ]);

        $currentYear = now()->year;
        $startYear = $request->year_start ?? $currentYear - 3;
        $endYear = $request->year_end ?? $currentYear;

        $years = collect(range($startYear, $endYear));
        $result = [];

        foreach ($years as $year) {
            $alumnis = Alumni::whereYear('graduation_date', $year);

            if ($request->filled('study_program')) {
                $alumnis->where('study_program', $request->study_program);
            }

            $result[] = [
                'year' => $year,
                'count_alumni' => (clone $alumnis)->count(),
                'count_alumni_filled' => (clone $alumnis)->whereNotNull('profession_id')->count(),
                'avg_waiting_time' => round((clone $alumnis)->avg('waiting_time') ?? 0, 2),
            ];
        }

        return response()->json(['data' => $result]);
    }
}
