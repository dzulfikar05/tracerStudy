<?php

namespace App\Http\Controllers\Backoffice\Operational;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlumniRequest;
use App\Models\Alumni;
use App\Models\Answer;
use App\Models\Company;
use App\Models\Profession;
use App\Models\ProfessionCategory;
use App\Models\Question;
use App\Models\Questionnaire;
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
            $alumnis->whereYear('graduation_date', '<=', $endYear);
        }
        if ($request->filled('study_program')) {
            $alumnis->where('study_program', $request->study_program);
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
                    $q->where('scope', 'businessman');
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

    public function getTableAssessment(Request $request)
    {
        $request->validate([
            'year_start' => 'nullable|integer',
            'year_end' => 'nullable|integer',
            'study_program' => 'nullable|string|max:255',
        ]);

        $alumniIds = Alumni::query()
            ->when($request->filled('year_start'), fn($q) => $q->whereYear('graduation_date', '>=', $request->year_start))
            ->when($request->filled('year_end'), fn($q) => $q->whereYear('graduation_date', '<=', $request->year_end))
            ->when($request->filled('study_program'), fn($q) => $q->where('study_program', $request->study_program))
            ->pluck('id');

        $questionnaire = Questionnaire::where('is_dashboard', true)
            ->with(['questions' => fn($q) => $q->where('is_assessment', true)])
            ->first();

        if (!$questionnaire) {
            return response()->json([
                'data' => null,
                'get_headers' => [],
                'list_answer' => [],
                'footer_total' => [],
                'message' => 'Data questionnaire assessment tidak ditemukan.',
            ]);
        }

        $questions = $questionnaire->questions;

        $getHeaders = $questions->pluck('options')
            ->map(fn($options) => json_decode($options, true))
            ->flatten()
            ->unique()
            ->values()
            ->toArray();

        $answers = Answer::where('questionnaire_id', $questionnaire->id)
            ->where('is_assessment', true)
            ->where(function ($q) use ($alumniIds) {
                $q->where(function ($q1) use ($alumniIds) {
                    $q1->where('filler_type', 'alumni')
                        ->whereIn('filler_id', $alumniIds);
                })->orWhere(function ($q2) use ($alumniIds) {
                    $q2->where('filler_type', 'superior')
                        ->whereIn('alumni_id', $alumniIds);
                });
            })
            ->select('question_id', 'answer')
            ->get()
            ->groupBy('question_id');

        $listAnswer = [];
        $footerTotal = array_fill_keys($getHeaders, 0);

        foreach ($questions as $question) {
            $questionId = $question->id;
            $questionText = $question->question;
            $questionAnswers = $answers->get($questionId, collect());

            $totalPerQuestion = $questionAnswers->count();
            $listAnswer[$questionText] = [];

            foreach ($getHeaders as $header) {
                $count = $questionAnswers->where('answer', $header)->count();
                $percentage = $totalPerQuestion > 0 ? round(($count / $totalPerQuestion) * 100, 2) : 0;
                $listAnswer[$questionText][$header] = $percentage;
            }
        }

        $totalQuestions = count($questions);
        foreach ($getHeaders as $header) {
            $sumHeader = array_sum(array_column($listAnswer, $header));
            $footerTotal[$header] = $totalQuestions > 0 ? round($sumHeader / $totalQuestions, 2) : 0;
        }

        return response()->json([
            'data' => $questionnaire,
            'get_headers' => $getHeaders,
            'list_answer' => $listAnswer,
            'footer_total' => $footerTotal,
        ]);
    }

    public function getChartAssessment(Request $request)
    {
        $request->validate([
            'year_start' => 'nullable|integer',
            'year_end' => 'nullable|integer',
            'study_program' => 'nullable|string|max:255',
        ]);

        // Ambil ID Alumni sesuai filter
        $alumniIds = Alumni::query()
            ->when($request->filled('year_start'), fn($q) => $q->whereYear('graduation_date', '>=', $request->year_start))
            ->when($request->filled('year_end'), fn($q) => $q->whereYear('graduation_date', '<=', $request->year_end))
            ->when($request->filled('study_program'), fn($q) => $q->where('study_program', $request->study_program))
            ->pluck('id');

        // Ambil pertanyaan assessment
        $questionnaire = Questionnaire::where('is_dashboard', true)
            ->with(['questions' => fn($q) => $q->where('is_assessment', true)])
            ->first();

        if (!$questionnaire) {
            return response()->json([
                'data' => null,
                'message' => 'Data questionnaire assessment tidak ditemukan.',
            ]);
        }

        $questions = $questionnaire->questions;

        // Buat data chart untuk tiap pertanyaan
        $chartData = [];

        foreach ($questions as $question) {
            $counts = DB::table('answers')
                ->select('answer', DB::raw('COUNT(*) as total'))
                ->where('question_id', $question->id)
                ->whereIn('alumni_id', $alumniIds)
                ->groupBy('answer')
                ->pluck('total', 'answer');

            $total = $counts->sum();

            $data = [];
            foreach (json_decode($question->options) as $option) {
                $count = $counts[$option] ?? 0;
                $percentage = $total ? round(($count / $total) * 100, 1) : 0;
                $data[] = [
                    'label' => $option,
                    'count' => $count,
                    'percentage' => $percentage,
                ];
            }

            $chartData[] = [
                'question' => $question->question,
                'data' => $data,
            ];
        }

        return response()->json([
            'data' => $chartData,
        ]);
    }
}
