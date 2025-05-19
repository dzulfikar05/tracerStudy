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
        return view('layouts.index', [
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
                ->addColumn('profession_category_name', function ($row) {
                    return $row->profession_category->name;
                })
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $btn = '<div class="dropstart">
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
                                    <a class="dropdown-item text-danger" href="#" onclick="onDelete(this)" data-id="' . $id . '">
                                        <i class="fa fa-trash me-2"></i>Hapus
                                    </a>
                                </li>
                            </ul>
                        </div>
                                ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backoffice.profession.index');
    }


    public function fetchAll(){
        $operation = Profession::get();
        return $operation;
    }

    public function store(ProfessionRequest $request){

        $params = $request->validated();
        $keyName = strtolower(trim($params['name']));
        $exists = Profession::whereRaw('LOWER(TRIM(name)) = ?', [$keyName])->exists();
        if($exists){
            return $this->sendResponse(false, 'Perusahaan Sudah Terdaftar', 'Perusahaan Sudah Terdaftar');
        }

        $operation = Profession::insert($request->validated());
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id)
    {
        $operation = Profession::find($id);
        return $operation;
    }

    public function update($id, ProfessionRequest $request)
    {
        $operation = Profession::where('id', $id)->update($request->validated());
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id)
    {
        $operation = Profession::where('id', $id)->delete();

        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }

    public function export_excel()
    {
        $professions = Profession::with('profession_category')->orderBy('id')->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Kategori');

        $row = 2;
        foreach ($professions as $profession) {
            $sheet->setCellValue('A' . $row, $profession->id);
            $sheet->setCellValue('B' . $row, $profession->name);
            $sheet->setCellValue('C' . $row, $profession->profession_category->name ?? '-');
            $row++;
        }

        $filename = 'Data_Profesi_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

}
