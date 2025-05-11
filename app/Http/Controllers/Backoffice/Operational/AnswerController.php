<?php

namespace App\Http\Controllers\Backoffice\Operational;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class AnswerController extends Controller
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
            $data = Answer::with('questionnaire', 'filler_alumni', 'filler_superior', 'alumni')->get();

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

    public function edit($id)
    {
        $operation = Answer::find($id);
        return $operation;
    }


    public function destroy($id)
    {
        $operation = Answer::where('id', $id)->delete();

        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }

    public function show($id)
    {
        $data = Answer::with('questions')->find($id);
        return view('layouts.index', [
            'title' => 'List Pertanyaan ' . $data->title,
            'content' => view('backoffice.questionnaire.question')->with('data', $data)
        ]);
    }
}
