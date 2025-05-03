<?php

namespace App\Http\Controllers\Backoffice\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\userRequest;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;


class UserController extends Controller
{
    public function index()
    {
        return view('layouts.index',[
			'title' => 'User',
			'content' => view('backoffice.user.index')
		]);
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = user::get();

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

        return view('backoffice.user.index');
    }

    public function store(userRequest $request){
        $payload = $request->validated();

        $checkEmail = user::where('email', $payload['email'])->first();
        if($checkEmail){
            return $this->sendResponse(false, 'Email Sudah Terdaftar', 'Gagal Menambahkan Data');
        }

        $payload['password'] = Hash::make($payload['password']);
        $operation = user::insert($payload);
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id){
        $operation = user::find($id);
        return $operation;
    }

    public function update($id, userRequest $request)
    {
        $payload = $request->validated();

        $checkEmail = user::where('email', $payload['email'])->where('id', '!=', $id)->first();
        if($checkEmail){
            return $this->sendResponse(false, 'Email Sudah Terdaftar', 'Gagal Mengubah Data');
        }

        if($payload['password'] == null || $payload['password'] == ''){
            unset($payload['password']);
        }
        if(isset($payload['password'])){
            $payload['password'] = Hash::make($payload['password']);
        }


        $operation = user::where('id', $id)->update($payload);
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id){
        $operation = user::where('id', $id)->delete();

        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }
}
