<?php

namespace App\Http\Controllers\Backoffice\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfessionCategoryRequest;
use App\Models\ProfessionCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;



class ProfessionCategoryController extends Controller
{
    public function index()
    {
        return view('layouts.index', [
            'title' => 'Kategori Profesi',
            'content' => view('backoffice.profession_category.index')
        ]);
    }

    public function fetchAll()
    {
        $data = ProfessionCategory::all();
        return $data;
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = ProfessionCategory::all();

            return DataTables::of($data)
                ->addIndexColumn()
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
                        </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backoffice.profession_category.index');
    }

    public function store(ProfessionCategoryRequest $request)
    {
        $operation = ProfessionCategory::insert($request->validated());
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id)
    {
        $operation = ProfessionCategory::find($id);
        return $operation;
    }

    public function update($id, ProfessionCategoryRequest $request)
    {
        $operation = ProfessionCategory::where('id', $id)->update($request->validated());
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id)
    {
        $operation = ProfessionCategory::where('id', $id)->delete();
        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }
    public function export_excel()
    {
        $categories = ProfessionCategory::select('id', 'name')->orderBy('id')->get();
    
        // Buat Spreadsheet baru
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Buat header kolom
        $sheet->setCellValue('A1', 'No'); 
        $sheet->setCellValue('B1', 'Nama');
    
        // Isi data mulai dari baris ke-2
        $row = 2;
        foreach ($categories as $index => $category) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $category->name);
            $row++;
        }

        foreach (range('A', 'B') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    
        // Siapkan response untuk download
        $filename = 'Data_Kategori_Profesi_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    
        // Output file Excel sebagai response
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
    
}
