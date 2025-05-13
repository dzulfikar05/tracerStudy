<?php

namespace App\Http\Controllers\Backoffice\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\userRequest;
use App\Models\user;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class UserController extends Controller
{
    public function index()
    {
        return view('layouts.index', [
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
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $btn = '<div >
                                        <a href="#" onclick="onEdit(this)" data-id="' . $id . '" title="Edit Data" class="btn btn-warning btn-sm"><i class="align-middle fa fa-pencil fw-light text-dark"> </i></a>
                                        <a href="#" onclick="onDelete(this)" data-id="' . $id . '" title="Delete Data" class="btn btn-danger btn-sm"><i class="align-middle fa fa-trash fw-light"> </i></a>
                                </div>
                                ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backoffice.user.index');
    }

    public function store(userRequest $request)
    {
        $payload = $request->validated();

        $checkEmail = user::where('email', $payload['email'])->first();
        if ($checkEmail) {
            return $this->sendResponse(false, 'Email Sudah Terdaftar', 'Gagal Menambahkan Data');
        }

        $payload['password'] = Hash::make($payload['password']);
        $operation = user::insert($payload);
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id)
    {
        $operation = user::find($id);
        return $operation;
    }

    public function update($id, userRequest $request)
    {
        $payload = $request->validated();

        $checkEmail = user::where('email', $payload['email'])->where('id', '!=', $id)->first();
        if ($checkEmail) {
            return $this->sendResponse(false, 'Email Sudah Terdaftar', 'Gagal Mengubah Data');
        }

        if ($payload['password'] == null || $payload['password'] == '') {
            unset($payload['password']);
        }
        if (isset($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        }


        $operation = user::where('id', $id)->update($payload);
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id)
    {
        $operation = user::where('id', $id)->delete();

        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }

    public function export_excel()
    {
        $users = User::select('id', 'name', 'email', 'email_verified_at', 'created_at')
            ->orderBy('id')
            ->get();

        // Buat Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('E1', 'Tanggal Dibuat');

        // Isi data mulai dari baris ke-2
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user->id);
            $sheet->setCellValue('B' . $row, $user->name);
            $sheet->setCellValue('C' . $row, $user->email);
            $sheet->setCellValue('E' . $row, $user->created_at);
            $row++;
        }

        // Siapkan nama file
        $filename = 'Data_User_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        // Output file Excel sebagai response
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
