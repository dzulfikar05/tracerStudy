<?php

namespace App\Http\Controllers\Backoffice\Operational;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionnaireRequest;
use App\Models\Alumni;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Superior;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;


class QuestionnaireController extends Controller
{
    public function index()
    {
        return view('layouts.index', [
            'title' => 'Kuisioner',
            'content' => view('backoffice.questionnaire.index')
        ]);
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = Questionnaire::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $hasAssessment = Question::where('questionnaire_id', $row->id)->where('is_assessment', true)->count() > 0;

                    $id = $row->id;
                    $btn = '
                        <div class="dropstart">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" style="z-index: 1050 !important; ">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="onEdit(this)" data-id="' . $id . '">
                                        <i class="fa fa-pencil me-2 text-warning"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="' . route('backoffice.questionnaire.show', $id) . '">
                                        <i class="fa fa-question-circle me-2 text-primary"></i>Lihat Pertanyaan
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="' . route('backoffice.questionnaire.show-answer', $id) . '">
                                        <i class="fa fa-eye me-2 text-primary"></i>Lihat Jawaban
                                    </a>
                                </li>
                        ';
                    if ($hasAssessment) {
                        $btn .= '<li>
                                        <a class="dropdown-item" href="' . route('backoffice.questionnaire.show-assessment', $id) . '">
                                            <i class="fa fa-eye me-2 text-primary"></i>Tabel Penilaian
                                        </a>
                                    </li>';
                    }

                    $btn .= '
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="onDelete(this)" data-id="' . $id . '">
                                        <i class="fa fa-trash me-2"></i>Hapus
                                    </a>
                                </li>
                            </ul>
                        </div>';

                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backoffice.questionnaire.index');
    }

    public function store(QuestionnaireRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = false;

        $operation = Questionnaire::insert($data);
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id)
    {
        $operation = Questionnaire::find($id);
        return $operation;
    }

    public function update($id, QuestionnaireRequest $request)
    {
        $operation = Questionnaire::where('id', $id)->update($request->validated());
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id)
    {
        $operation = Questionnaire::where('id', $id)->delete();

        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }

    public function toggleStatus($id)
    {
        $operation = Questionnaire::where('id', $id)->update(['is_active' => !Questionnaire::where('id', $id)->first()->is_active]);
        return $this->sendResponse($operation, 'Berhasil Mengubah Status', 'Gagal Mengubah Status');
    }

    public function toggleDashboard($id)
    {
        $operationUpdate = Questionnaire::where('id', $id)->update(['is_dashboard' => !Questionnaire::where('id', $id)->first()->is_dashboard]);
        $operation = Questionnaire::where('id', '!=', $id)->update(['is_dashboard' => false]);

        return $this->sendResponse($operationUpdate, 'Berhasil Mengubah Status', 'Gagal Mengubah Status');
    }

    public function show($id)
    {
        $data = Questionnaire::with('questions')->find($id);
        return view('layouts.index', [
            'title' => 'List Pertanyaan ' . $data->title,
            'content' => view('backoffice.questionnaire.question')->with('data', $data)
        ]);
    }

    public function showAnswer($id)
    {
        $data = Questionnaire::with('questions')->find($id);

        return view('layouts.index', [
            'title' => 'List Jawaban ' . $data->title,
            'content' => view('backoffice.questionnaire.answer')->with('data', $data)
        ]);
    }
    public function answerTable($id, Request $request)
    {
        if ($request->ajax()) {
            // Ambil data questionnaire dan questions dalam satu query
            $questionnaire = Questionnaire::with('questions')->findOrFail($id);
            $questions = $questionnaire->questions;

            // Ambil semua data respondents yang diperlukan dalam satu query
            $respondents = Answer::with([
                    'filler_superior',
                    'filler_alumni.superior',
                    'filler_alumni.company',
                    'filler_alumni.profession.profession_category',
                    'alumni.superior'
                ])
                ->where('questionnaire_id', $id)
                ->select('id', 'filler_type', 'filler_id', 'alumni_id', 'questionnaire_id')
                ->distinct()
                ->get();

            // Group answers berdasarkan filler_type dan filler_id
            $answers = Answer::where('questionnaire_id', $id)
                ->whereIn('filler_type', $respondents->pluck('filler_type'))
                ->whereIn('filler_id', $respondents->pluck('filler_id'))
                ->get()
                ->groupBy('filler_id');

            $fillerType = "";
            $fillerId = "";
            $data = $respondents->map(function ($responden) use ($questions, $answers, &$fillerType, &$fillerId) {
                if ($responden->filler_type == $fillerType && $responden->filler_id == $fillerId) {
                    return null;
                }

                $fillerType = $responden->filler_type;
                $fillerId = $responden->filler_id;

                // Ambil jawaban untuk respondent ini
                $responseAnswers = $answers[$responden->filler_id] ?? collect();
                $row = [
                    'id' => $responden->id,
                    'filler_type' => $responden->filler_type,
                    'filler_id' => $responden->filler_id,
                    'questionnaire_id' => $responden->questionnaire_id,
                ];

                if ($responden->filler_type == 'alumni') {

                    $filler = $responden->filler_alumni;
                    $row['study_program'] = $filler->study_program ?? '-';
                    $row['nim'] = $filler->nim ?? '-';
                    $row['full_name'] = $filler->full_name ?? '-';
                    $row['phone'] = $filler->phone ?? '-';
                    $row['email'] = $filler->email ?? '-';
                    $row['study_start_year'] =  $filler->study_start_year ?? '-';
                    $row['graduation_date'] = $filler->graduation_date ?? '-';
                    $row['graduation_year'] =  date('Y', strtotime($filler->graduation_date)) ?? '-';
                    $row['start_work_date'] = $filler->start_work_date ?? '-';
                    $row['waiting_time'] = $filler->waiting_time ?? '-';
                    $row['start_work_now_date'] = $filler->start_work_now_date ?? '-';

                    $row['company_type'] = $filler->company?->company_type ?? '-';
                    $row['company_name'] = $filler->company?->name ?? '-';
                    $row['company_scope'] = $filler->company?->scope ?? '-';
                    $row['company_address'] = $filler->company?->address ?? '-';

                    $row['profession_category'] = $filler->profession?->profession_category?->name ?? '-';
                    $row['profession'] = $filler->profession?->name ?? '-';

                    $superior = $responden->filler_alumni?->superior;
                    $row['superior_name'] = $superior?->full_name ?? '-';
                    $row['superior_position'] = $superior?->position ?? '-';
                    $row['superior_phone'] = $superior?->phone ?? '-';
                    $row['superior_email'] = $superior?->email ?? '-';

                } elseif ($responden->filler_type == 'superior') {
                    $filler = $responden->filler_superior;
                    $row['full_name'] = $filler->full_name ?? '-';
                    $row['company_name'] = $filler->company?->name ?? '-';
                    $row['position'] = $filler->position ?? '-';
                    $row['email'] = $filler->email ?? '-';

                    $alumni = $responden->alumni;
                    $row['alumni_name'] = $alumni->full_name ?? '-';
                    $row['alumni_study_program'] = $alumni->study_program ?? '-';
                    $row['study_start_year'] = $alumni->study_start_year ?? '-';
                    $row['graduation_year'] = date('Y', strtotime($alumni->graduation_date)) ?? '-';

                } else {
                    $row['filler_name'] = '-';
                }

                // Mengambil jawaban untuk setiap pertanyaan
                foreach ($questions as $question) {
                    $row["q_{$question->id}"] = $responseAnswers->firstWhere('question_id', $question->id)->answer ?? '-';
                }

                $row['pengisi'] = $row['filler_name'] ?? '-';

                return $row;
            })->filter(); // Memastikan data yang null atau tidak perlu disaring

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $fillerType = $row['filler_type'];
                    $fillerId = $row['filler_id'];
                    $questionnaireId = $row['questionnaire_id'];
                    return '
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi
                        </button>
                        <ul class="dropdown-menu" style="z-index: 1050 !important;">
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="onDeleteAnswer(this)"
                               data-filler-type="' . $fillerType . '"
                                data-filler-id="' . $fillerId . '"
                                data-questionnaire-id="' . $questionnaireId . '"
                                >
                                    <i class="fa fa-trash me-2"></i>Hapus
                                </a>
                            </li>
                        </ul>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backoffice.questionnaire.index');
    }

    public function deleteAnswer(Request $request)
    {
        $validated = $request->validate([
            'filler_type' => 'required|string',
            'filler_id' => 'required|integer',
            'questionnaire_id' => 'required|integer',
        ]);

        $answer = Answer::where('filler_type', $validated['filler_type'])
            ->where('filler_id', $validated['filler_id'])
            ->where('questionnaire_id', $validated['questionnaire_id'])
            ->first();

        if ($answer) {
            $operation = $answer->delete();
            return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
        }
        return $this->sendResponse(0, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }

    public function showAssessment($id)
    {
        $data = Questionnaire::with(['questions' => function ($q) {
            $q->where('is_assessment', true);
        }])->findOrFail($id);

        $getHeaders = Question::where('questionnaire_id', $id)
            ->where('is_assessment', true)
            ->pluck('options')
            ->map(fn($item) => json_decode($item, true))
            ->flatten()
            ->unique()
            ->values()
            ->toArray();

        $answers = Answer::where('questionnaire_id', $id)
            ->where('is_assessment', true)
            ->with('question')
            ->get();

        $listAnswer = [];
        $footerTotal = [];

        foreach ($getHeaders as $header) {
            $footerTotal[$header] = 0;
        }

        foreach ($data->questions as $question) {
            $questionAnswers = $answers->where('question_id', $question->id);
            $totalPerQuestion = $questionAnswers->count();

            foreach ($getHeaders as $header) {
                $listAnswer[$question->question][$header] = 0;
            }

            foreach ($getHeaders as $header) {
                $countPerHeader = $questionAnswers->filter(fn($a) => $a->answer === $header)->count();
                $percentage = $totalPerQuestion > 0 ? round(($countPerHeader / $totalPerQuestion) * 100, 2) : 0;
                $listAnswer[$question->question][$header] = $percentage;
            }
        }

        $totalQuestions = count($data->questions);
        foreach ($getHeaders as $header) {
            $sumHeader = collect($listAnswer)->pluck($header)->sum();
            $footerTotal[$header] = $totalQuestions > 0 ? round($sumHeader / $totalQuestions, 2) : 0;
        }

        return view('layouts.index', [
            'title' => 'Tabel Penilaian ' . $data->title,
            'content' => view('backoffice.questionnaire.assessment', compact('data', 'listAnswer', 'footerTotal', 'getHeaders'))
        ]);
    }
}
