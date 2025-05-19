<?php

namespace App\Http\Controllers\Backoffice\Operational;

use App\Http\Controllers\Controller;
use App\Models\Superior;
use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\SuperiorRequest;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SuperiorsController extends Controller
{
    public function index()
    {
        return view('layouts.index', [
            'title' => 'Superiors',
            'content' => view('backoffice.superiors.index')
        ]);
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = Superior::with('company')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('company_name', function($row) {
                    return $row->company?->name ?? '';
                })
                ->addColumn('action', function($row) {
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

        return view('backoffice.superiors.index');
    }

    public function store(SuperiorRequest $request)
    {
        $validated = $request->validated();
        $operation = Superior::insert($validated);
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id)
    {
        $operation = Superior::find($id);
        return $operation;
    }

    public function update(SuperiorRequest $request, $id)
    {
        $validated = $request->validated();
        $operation = Superior::where('id', $id)->update($validated);
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id)
    {
        $operation = Superior::where('id', $id)->delete();
        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }

    public function fetchOptions(Request $request)
    {
        $companies = Company::get();
        return response()->json([
            'companies' => $companies
        ]);
    }

    public function exportExcel()
    {
        // Ambil data superior dengan relasi company
        $superiors = Superior::with('company')->get();
        
        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'Posisi');
        $sheet->setCellValue('D1', 'Telepon');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Perusahaan');
        
        // Isi data
        $row = 2;
        foreach ($superiors as $index => $superior) {
            $sheet->setCellValue('A'.$row, $index + 1);
            $sheet->setCellValue('B'.$row, $superior->full_name);
            $sheet->setCellValue('C'.$row, $superior->position);
            $sheet->setCellValue('D'.$row, $superior->phone);
            $sheet->setCellValue('E'.$row, $superior->email);
            $sheet->setCellValue('F'.$row, $superior->company?->name ?? '-');
            $row++;
        }
        
        // Set auto size untuk kolom
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        
        // Set judul sheet
        $sheet->setTitle('Data Superior');
        
        // Buat writer dan output
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data_Superior_'.date('Y-m-d_His').'.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}