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
            'title' => 'Atasan',
            'content' => view('backoffice.superiors.index')
        ]);
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $query = Superior::with('company');

            if ($request->filled('position')) {
                $query->where('position', $request->position);
            }

            if ($request->filled('company')) {
                $query->where('company_id', $request->company);
            }


            $data = $query->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('company_name', function ($row) {
                    return $row->company?->name ?? '';
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
        $positions = Superior::select('position')->distinct()->pluck('position');

        return response()->json([
            'companies' => $companies,
            'positions' => $positions
        ]);
    }

    public function exportExcel(Request $request)
    {
        \Log::info('Export filter position: ' . $request->position);
        \Log::info('Export filter company: ' . $request->company);

        $query = Superior::with('company');

        if (!empty($request->position)) {
            $query->where('position', $request->position);
        }

        if (!empty($request->company)) {
            $query->where('company_id', $request->company);
        }

        $superiors = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'Posisi');
        $sheet->setCellValue('D1', 'Telepon');
        $sheet->setCellValue('E1', 'Email');
        $sheet->setCellValue('F1', 'Perusahaan');

        // Data
        $row = 2;
        foreach ($superiors as $index => $superior) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $superior->full_name);
            $sheet->setCellValue('C' . $row, $superior->position);
            $sheet->setCellValue('D' . $row, $superior->phone);
            $sheet->setCellValue('E' . $row, $superior->email);
            $sheet->setCellValue('F' . $row, $superior->company?->name ?? '-');
            $row++;
        }

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->setTitle('Data Superior');

        $writer = new Xlsx($spreadsheet);
        $filename = 'Data_Superior_' . date('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function showAlumni($id)
    {
        $alumnis = \App\Models\Alumni::where('superior_id', $id)->get(); // pastikan kolom ini ada
        return view('backoffice.superiors.modal_alumni', compact('alumnis'));
    }
}
