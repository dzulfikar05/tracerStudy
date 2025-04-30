<?php

namespace App\Http\Controllers\Backoffice\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfessionRequest;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;


class ProfessionController extends Controller
{
    public function index()
    {
        return view('layouts.index',[
			'title' => 'Profession',
			'content' => view('backoffice.profession.index')
		]);
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = Profession::with('profession_category')->get();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('profession_category_name', function($row){
                        return $row->profession_category->name;
                    })
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

        return view('backoffice.profession.index');
    }

    public function store(ProfessionRequest $request){
        $operation = Profession::insert($request->validated());
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id){
        $operation = Profession::find($id);
        return $operation;
    }

    public function update($id, ProfessionRequest $request)
    {
        $operation = Profession::where('id', $id)->update($request->validated());
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id){
        $operation = Profession::where('id', $id)->delete();

        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }
}
