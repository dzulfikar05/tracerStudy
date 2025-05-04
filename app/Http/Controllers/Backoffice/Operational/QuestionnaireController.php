<?php

namespace App\Http\Controllers\Backoffice\Operational;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionnaireRequest;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;


class QuestionnaireController extends Controller
{
    public function index()
    {
        return view('layouts.index',[
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
                    ->addColumn('action', function($row){
                        $id = $row->id;
                           $btn = '<div >
                                        <a href="#" onclick="onEdit(this)" data-id="'.$id.'" title="Edit Data" class="btn btn-warning btn-sm"><i class="align-middle fa fa-pencil fw-light text-dark"> </i></a>

                                        <a href="'.route('backoffice.questionnaire.show', $id).'"  title="Show Data" class="btn btn-primary btn-sm"><i class="align-middle fa fa-eye fw-light"> </i></a>

                                        <a href="#" onclick="onDelete(this)" data-id="'.$id.'" title="Delete Data" class="btn btn-danger btn-sm"><i class="align-middle fa fa-trash fw-light"> </i></a>
                                </div>
                                ';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('backoffice.questionnaire.index');
    }

    public function store(QuestionnaireRequest $request){
        $operation = Questionnaire::insert($request->validated());
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id){
        $operation = Questionnaire::find($id);
        return $operation;
    }

    public function update($id, QuestionnaireRequest $request)
    {
        $operation = Questionnaire::where('id', $id)->update($request->validated());
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id){
        $operation = Questionnaire::where('id', $id)->delete();

        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }

    public function toggleStatus($id){
        $operation = Questionnaire::where('id', $id)->update(['is_active' => !Questionnaire::where('id', $id)->first()->is_active]);
        return $this->sendResponse($operation, 'Berhasil Mengubah Status', 'Gagal Mengubah Status');
    }

    public function show($id){
        $data = Questionnaire::with('questions')->find($id);
        return view('layouts.index',[
			'title' => 'List Pertanyaan ' . $data->title,
            'content' => view('backoffice.questionnaire.question')->with('data', $data)
		]);
    }
}
