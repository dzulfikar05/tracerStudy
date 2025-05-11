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
                    $id = $row->id;
                    $btn = '
                        <div class="dropdown">
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
            $respondents = Answer::with(['filler_superior', 'filler_alumni', 'alumni'])
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
                    $row['filler_name'] = $filler->full_name ?? '-';
                    $row['nim'] = $filler->nim ?? '-';
                    $row['email'] = $filler->email ?? '-';
                    $row['study_program'] = $filler->study_program ?? '-';
                    $row['company_name'] = $filler->company?->name ?? '-';
                    $row['company_address'] = $filler->company?->address ?? '-';
                    $row['company_type'] = $filler->company?->company_type ?? '-';
                } elseif ($responden->filler_type == 'superior') {
                    $filler = $responden->filler_superior;
                    $row['filler_name'] = $filler->full_name ?? '-';
                    $row['position'] = $filler->position ?? '-';
                    $row['company_name'] = $filler->company?->name ?? '-';
                    $row['company_address'] = $filler->company?->address ?? '-';
                    $row['company_type'] = $filler->company?->company_type ?? '-';
                } else {
                    $row['filler_name'] = '-';
                }

                if ($responden->alumni_id) {
                    $alumni = $responden->alumni;
                    $row['alumni_name'] = $alumni->full_name ?? '-';
                    $row['alumni_nim'] = $alumni->nim ?? '-';
                    $row['alumni_study_program'] = $alumni->study_program ?? '-';
                } else {
                    $row['alumni_name'] = '-';
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
}
