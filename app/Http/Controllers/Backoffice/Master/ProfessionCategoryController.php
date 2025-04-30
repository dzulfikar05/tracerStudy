<?php

namespace App\Http\Controllers\Backoffice\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfessionCategoryRequest;
use App\Models\ProfessionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;


class ProfessionCategoryController extends Controller
{
    public function index()
    {
        return view('layouts.index',[
			'title' => 'Job Category',
			'content' => view('backoffice.profession_category.index')
		]);
    }

    public function fetchAll(){
        $data = ProfessionCategory::all();
        return $data;
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = ProfessionCategory::all();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $id = $row->id;
                           $btn = '<div >
                                        <a href="#" onclick="onEdit(this)" data-id="'.$id.'" title="Edit Data" class="btn btn-warning btn-sm"><i class="align-middle fa fa-pencil fw-light text-dark"> </i></a>
                                        <a href="#" onclick="onDelete(this)" data-id="'.$id.'" title="Delete Data" class="btn btn-danger btn-sm"><i class="align-middle fa fa-trash fw-light"> </i></a>
                                </div>
                                ';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('backoffice.profession_category.index');
    }

    public function store(ProfessionCategoryRequest $request){
        $operation = ProfessionCategory::insert($request->validated());
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id){
        $operation = ProfessionCategory::find($id);
        return $operation;
    }

    public function update($id, ProfessionCategoryRequest $request)
    {
        $operation = ProfessionCategory::where('id', $id)->update($request->validated());
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id){
        $operation = ProfessionCategory::where('id', $id)->delete();
        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }
}
