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
            'title' => 'Profesi',
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

    // === BAGIAN HEADER INFORMASI (5 BARIS TERATAS) ===
    
    // Baris 1: Judul utama
    $sheet->setCellValue('A1', 'DATA PROFESI');
    $sheet->mergeCells('A1:C1');
    $sheet->getStyle('A1')->applyFromArray([
        'font' => [
            'bold' => true,
            'size' => 16
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ]
    ]);

    // Baris 2: Tanggal export
    $sheet->setCellValue('A2', 'Tanggal Export: ' . date('d-m-Y H:i:s'));
    $sheet->mergeCells('A2:C2');
    $sheet->getStyle('A2')->applyFromArray([
        'font' => [
            'italic' => true,
            'size' => 10
        ]
    ]);

    // Baris 3: Total data
    $sheet->setCellValue('A3', 'Total Data: ' . $professions->count() . ' profesi');
    $sheet->mergeCells('A3:C3');
    $sheet->getStyle('A3')->applyFromArray([
        'font' => [
            'size' => 10
        ]
    ]);

    // Baris 4-5: Kosong untuk spacing
    $sheet->setCellValue('A4', '');
    $sheet->setCellValue('A5', '');

    // === BAGIAN HEADER TABEL (BARIS 6) ===
    $headerRow = 6;
    $sheet->setCellValue('A' . $headerRow, 'No');
    $sheet->setCellValue('B' . $headerRow, 'Nama Profesi');
    $sheet->setCellValue('C' . $headerRow, 'Kategori');

    // Style untuk header dengan background color
    $sheet->getStyle('A' . $headerRow . ':C' . $headerRow)->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF']
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4472C4']
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000']
            ]
        ]
    ]);

    // === BAGIAN DATA (MULAI BARIS 7) ===
    $dataStartRow = $headerRow + 1;
    $currentRow = $dataStartRow;

    foreach ($professions as $index => $profession) {
        $sheet->setCellValue('A' . $currentRow, $index + 1);
        $sheet->setCellValue('B' . $currentRow, $profession->name);
        $sheet->setCellValue('C' . $currentRow, $profession->profession_category->name ?? '-');
        
        // Style untuk baris data
        $sheet->getStyle('A' . $currentRow . ':C' . $currentRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ]
        ]);
        
        $sheet->getStyle('A' . $currentRow)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $currentRow++;
    }

    // Pengaturan kolom
    $sheet->getColumnDimension('A')->setWidth(8);
    $sheet->getColumnDimension('B')->setWidth(30);
    $sheet->getColumnDimension('C')->setWidth(25);

    // Set tinggi baris
    $sheet->getRowDimension(1)->setRowHeight(30);
    $sheet->getRowDimension($headerRow)->setRowHeight(25);

    $filename = 'Data_Profesi_' . date('Y-m-d_H-i-s') . '.xlsx';
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
}

}
