<?php

namespace App\Http\Controllers\Backoffice\Master;

use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;


class JobCategoryController extends Controller
{
    public function index()
    {
        return view('layouts.index',[
			'title' => 'Job Category',
			'content' => view('backoffice.job_category.index')
		]);
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = JobCategory::all();

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

        return view('backoffice.job_category.index');
    }

    public function store(Request $request){
        $data = $request->input();
        $operation = JobCategory::insert($data);

        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit(Request $request){
        $id = $request->input('id');
        $operation = JobCategory::find($id);

        return $operation;
    }

    public function update(Request $request)
    {
        $data = $request->input();
        $operation = JobCategory::where('id', $data['id'])->update($data);

        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy(Request $request){
        $id = $request->input('id');
        $operation = JobCategory::where('id', $id)->delete();

        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }
}
