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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


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
            $data = Questionnaire::query();

            if ($request->filled('title')) {
                $data->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->filled('period_year')) {
                $data->where('period_year', 'like', '%' . $request->period_year . '%');
            }
            if ($request->filled('type')) {
                $data->where('type', 'like', '%' . $request->type . '%');
            }

            return DataTables::of($data->get())
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
            // Ambil kuesioner beserta pertanyaannya
            $questionnaire = Questionnaire::with('questions')->findOrFail($id);
            $questions = $questionnaire->questions;

            // **PERUBAHAN UTAMA DI SINI:**
            // Kita akan mengambil SEMUA jawaban yang relevan terlebih dahulu,
            // kemudian mengelompokkan untuk mendapatkan responden unik.
            $allAnswers = Answer::where('questionnaire_id', $id)
                ->with([
                    'filler_superior',
                    'filler_alumni.superior',
                    'filler_alumni.company',
                    'filler_alumni.profession.profession_category',
                    'alumni.superior'
                ])
                ->get();

            // Filter jawaban berdasarkan request (misalnya, program studi, angkatan, dll.)
            // Kita akan membangun koleksi responden unik dari jawaban yang difilter.
            $filteredRespondents = $allAnswers->filter(function ($answer) use ($request, $questionnaire) {
                $relationAlumni = $questionnaire->type === 'alumni' ? $answer->filler_alumni : $answer->alumni;

                // Terapkan filter yang sama seperti sebelumnya, tapi pada koleksi Eloquent
                $matches = true;

                if ($request->filled('study_program') && ($relationAlumni->study_program ?? '-') !== $request->study_program) {
                    $matches = false;
                }
                if ($request->filled('nim') && !str_contains(strtolower($relationAlumni->nim ?? '-'), strtolower($request->nim))) {
                    $matches = false;
                }
                if ($request->filled('study_start_year') && ($relationAlumni->study_start_year ?? '-') != $request->study_start_year) {
                    $matches = false;
                }
                if ($request->filled('graduation_year') && date('Y', strtotime($relationAlumni->graduation_date ?? '')) != $request->graduation_year) {
                    $matches = false;
                }
                if ($request->filled('company_id') && ($relationAlumni->company->id ?? '-') != $request->company_id) {
                    $matches = false;
                }
                if ($request->filled('profession_category_id') && ($relationAlumni->profession->profession_category->id ?? '-') != $request->profession_category_id) {
                    $matches = false;
                }
                if ($request->filled('profession_id') && ($relationAlumni->profession->id ?? '-') != $request->profession_id) {
                    $matches = false;
                }
                return $matches;
            });

            // Sekarang, kelompokkan responden yang sudah difilter untuk mendapatkan entri unik
            // untuk ditampilkan di tabel.
            $respondents = $filteredRespondents->unique(function ($item) {
                if ($item->filler_type === 'superior') {
                    // Untuk superior, unik berdasarkan siapa (filler) mengisi untuk siapa (alumni)
                    return $item->questionnaire_id . '-' . $item->filler_id . '-' . $item->alumni_id;
                } else {
                    // Untuk alumni, unik berdasarkan siapa (alumni) mengisi untuk dirinya sendiri
                    return $item->questionnaire_id . '-' . $item->filler_id;
                }
            });


            // Ambil semua jawaban yang relevan dari *semua* jawaban yang sudah difilter
            // dan kelompokkan berdasarkan kombinasi unik yang sama
            $answersGrouped = $filteredRespondents->groupBy(function ($item) {
                if ($item->filler_type === 'superior') {
                    return $item->filler_type . '-' . $item->filler_id . '-' . $item->alumni_id;
                } else {
                    return $item->filler_type . '-' . $item->filler_id;
                }
            });

            // Siapkan data untuk DataTables
            $data = $respondents->map(function ($responden) use ($questions, $answersGrouped) {
                // Buat kunci komposit yang sama untuk mengambil jawaban spesifik
                $compositeKey = '';
                if ($responden->filler_type === 'superior') {
                    $compositeKey = $responden->filler_type . '-' . $responden->filler_id . '-' . $responden->alumni_id;
                } else {
                    $compositeKey = $responden->filler_type . '-' . $responden->filler_id;
                }

                $responseAnswers = $answersGrouped[$compositeKey] ?? collect();

                // START OF THE PART YOU DO NOT WANT TO CHANGE
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
                    $row['study_start_year'] = $filler->study_start_year ?? '-';
                    $row['graduation_date'] = $filler->graduation_date ?? '-';
                    $row['graduation_year'] = date('Y', strtotime($filler->graduation_date)) ?? '-';
                    $row['start_work_date'] = $filler->start_work_date ?? '-';
                    $row['waiting_time'] = $filler->waiting_time ?? '-';
                    $row['start_work_now_date'] = $filler->start_work_now_date ?? '-';

                    $row['company_type'] = $filler->company?->company_type ?? '-';
                    $row['company_name'] = $filler->company?->name ?? '-';
                    $row['company_scope'] = $filler->company?->scope ?? '-';
                    $row['company_address'] = $filler->company?->address ?? '-';

                    $row['profession_category'] = $filler->profession?->profession_category?->name ?? '-';
                    $row['profession'] = $filler->profession?->name ?? '-';

                    $superior = $filler?->superior;
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

                foreach ($questions as $question) {
                    // Ambil jawaban spesifik dari koleksi $responseAnswers
                    $row["q_{$question->id}"] = $responseAnswers->firstWhere('question_id', $question->id)->answer ?? '-';
                }
                // END OF THE PART YOU DO NOT WANT TO CHANGE

                // Tambahkan kolom 'pengisi' di luar bagian yang tidak ingin diubah
                $row['pengisi'] = ($responden->filler_type == 'alumni' ? ($responden->filler_alumni->full_name ?? '-') : ($responden->filler_superior->full_name ?? '-'));

                return $row;
            })->filter();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alumniIdAttribute = ($row['filler_type'] === 'superior' && isset($row['alumni_id'])) ? 'data-alumni-id="' . $row['alumni_id'] . '"' : '';

                    return '
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Aksi
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="onDeleteAnswer(this)"
                                        data-filler-type="' . $row['filler_type'] . '"
                                        data-filler-id="' . $row['filler_id'] . '"
                                        ' . $alumniIdAttribute . '
                                        data-questionnaire-id="' . $row['questionnaire_id'] . '"
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


    public function exportAnswer($id, Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $questionnaire = Questionnaire::with('questions')->findOrFail($id);
        $questions = $questionnaire->questions;

        $allAnswers = Answer::where('questionnaire_id', $id)
            ->with([
                'filler_superior',
                'filler_alumni.superior',
                'filler_alumni.company',
                'filler_alumni.profession.profession_category',
                'alumni.superior'
            ])
            ->get();

        $filteredAnswers = $allAnswers->filter(function ($answer) use ($request, $questionnaire) {
            $relevantAlumniRelation = null;
            if ($questionnaire->type === 'alumni') {
                $relevantAlumniRelation = $answer->filler_alumni;
            } elseif ($questionnaire->type === 'superior') {
                $relevantAlumniRelation = $answer->alumni;
            }


            $matches = true;

            if ($request->filled('study_program') && ($relevantAlumniRelation->study_program ?? '-') !== $request->study_program) {
                $matches = false;
            }
            if ($request->filled('nim') && !str_contains(strtolower($relevantAlumniRelation->nim ?? '-'), strtolower($request->nim))) {
                $matches = false;
            }
            if ($request->filled('study_start_year') && ($relevantAlumniRelation->study_start_year ?? '-') != $request->study_start_year) {
                $matches = false;
            }
            if ($request->filled('graduation_year')) {
                $graduationYear = $relevantAlumniRelation->graduation_date ? date('Y', strtotime($relevantAlumniRelation->graduation_date)) : '-';
                if ($graduationYear != $request->graduation_year) {
                    $matches = false;
                }
            }
            if ($request->filled('company_id') && ($relevantAlumniRelation->company->id ?? '-') != $request->company_id) {
                $matches = false;
            }
            if ($request->filled('profession_category_id') && ($relevantAlumniRelation->profession->profession_category->id ?? '-') != $request->profession_category_id) {
                $matches = false;
            }
            if ($request->filled('profession_id') && ($relevantAlumniRelation->profession->id ?? '-') != $request->profession_id) {
                $matches = false;
            }

            if ($request->filled('superior')) {
                if ($questionnaire->type === 'alumni') {
                    if (($relevantAlumniRelation->superior->id ?? '-') != $request->superior) {
                        $matches = false;
                    }
                }

                elseif ($questionnaire->type === 'superior') {
                    if (($answer->filler_superior->id ?? '-') != $request->superior) {
                        $matches = false;
                    }
                }
            }

            return $matches;
        });

        $respondents = $filteredAnswers->unique(function ($item) use ($questionnaire) {
            if ($item->filler_type === 'superior') {
                return $item->questionnaire_id . '-' . $item->filler_id . '-' . $item->alumni_id;
            } else {
                return $item->questionnaire_id . '-' . $item->filler_id;
            }
        });

        $answersGrouped = $filteredAnswers->groupBy(function ($item) {
            if ($item->filler_type === 'superior') {
                return $item->filler_type . '-' . $item->filler_id . '-' . $item->alumni_id;
            } else {
                return $item->filler_type . '-' . $item->filler_id;
            }
        });

        $row = 1;
        $colIndex = 1;

        $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex) . $row, 'No');
        $colIndex++;

        $type = $questionnaire->type;

        $alumniHeaders = [
            'Program Studi', 'NIM', 'Nama', 'No. HP', 'Email', 'Angkatan',
            'Tanggal Lulus', 'Tahun Lulus', 'Tanggal Pertama Kerja', 'Masa Tunggu',
            'Tanggal Kerja Instansi', 'Jenis Instansi', 'Nama Instansi', 'Skala',
            'Lokasi', 'Kategori Profesi', 'Profesi', 'Nama Atasan Langsung',
            'Jabatan Atasan Langsung', 'No. HP Atasan Langsung', 'Email Atasan'
        ];

        $superiorHeaders = [
            'Nama', 'Instansi', 'Jabatan', 'Email', 'Nama Alumni',
            'Program Studi Alumni',
            'Angkatan Alumni',
            'Tahun Lulus Alumni'
        ];

        if ($type == 'alumni') {
            foreach ($alumniHeaders as $header) {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex) . $row, $header);
                $colIndex++;
            }
        } elseif ($type == 'superior') {
            foreach ($superiorHeaders as $header) {
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex) . $row, $header);
                $colIndex++;
            }
        }

        foreach ($questions as $question) {
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex) . $row, $question->question);
            $colIndex++;
        }

        $row = 2;

        foreach ($respondents as $i => $res) {
            $colIndex = 1;

            $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex) . $row, $i + 1);
            $colIndex++;

            if ($res->filler_type == 'alumni') {
                $filler = $res->filler_alumni;

                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->study_program ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->nim ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->full_name ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->phone ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->email ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->study_start_year ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->graduation_date ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->graduation_date ? date('Y', strtotime($filler->graduation_date)) : '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->start_work_date ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->waiting_time ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->start_work_now_date ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->company?->company_type ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->company?->name ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->company?->scope ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->company?->address ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->profession?->profession_category?->name ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->profession?->name ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->superior?->full_name ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->superior?->position ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->superior?->phone ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->superior?->email ?? '-');
            } elseif ($res->filler_type == 'superior') {
                $filler = $res->filler_superior;
                $alumni = $res->alumni;

                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->full_name ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->company?->name ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->position ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $filler->email ?? '-');

                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $alumni->full_name ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $alumni->study_program ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $alumni->study_start_year ?? '-');
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $alumni->graduation_date ? date('Y', strtotime($alumni->graduation_date)) : '-');
            }

            $compositeKey = '';
            if ($res->filler_type === 'superior') {
                $compositeKey = $res->filler_type . '-' . $res->filler_id . '-' . $res->alumni_id;
            } else {
                $compositeKey = $res->filler_type . '-' . $res->filler_id;
            }
            $answerList = $answersGrouped[$compositeKey] ?? collect();
            foreach ($questions as $question) {
                $answerText = $answerList->firstWhere('question_id', $question->id)->answer ?? '-';
                $sheet->setCellValue(Coordinate::stringFromColumnIndex($colIndex++) . $row, $answerText);
            }

            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Jawaban_Questionnaire_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
