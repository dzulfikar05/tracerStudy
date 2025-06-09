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
    // Ambil data kategori profesi
    $categories = ProfessionCategory::select('id', 'name')->orderBy('id')->get();

    // Buat Spreadsheet baru
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // === BAGIAN HEADER INFORMASI (5 BARIS TERATAS) ===
    
    // Baris 1: Judul utama
    $sheet->setCellValue('A1', 'DATA KATEGORI PROFESI');
    $sheet->mergeCells('A1:B1');
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
    $sheet->mergeCells('A2:B2');
    $sheet->getStyle('A2')->applyFromArray([
        'font' => [
            'italic' => true,
            'size' => 10
        ]
    ]);

    // Baris 3: Total data
    $sheet->setCellValue('A3', 'Total Data: ' . $categories->count() . ' kategori');
    $sheet->mergeCells('A3:B3');
    $sheet->getStyle('A3')->applyFromArray([
        'font' => [
            'size' => 10
        ]
    ]);

    // Baris 4: Informasi filter (jika ada, sekarang kosong)
    $sheet->setCellValue('A4', ''); // Kosong untuk spacing

    // Baris 5: Kosong untuk spacing
    $sheet->setCellValue('A5', ''); // Kosong untuk spacing

    // === BAGIAN HEADER TABEL (BARIS 6) ===
    $headerRow = 6;
    $sheet->setCellValue('A' . $headerRow, 'No');
    $sheet->setCellValue('B' . $headerRow, 'Nama Kategori');

    // Style untuk header dengan background color
    $sheet->getStyle('A' . $headerRow . ':B' . $headerRow)->applyFromArray([
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF']
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4472C4'] // Biru
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
    $dataStartRow = $headerRow + 1; // Baris 7
    $currentRow = $dataStartRow;

    foreach ($categories as $index => $category) {
        $sheet->setCellValue('A' . $currentRow, $index + 1);
        $sheet->setCellValue('B' . $currentRow, $category->name);
        
        // Style untuk baris data
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->applyFromArray([
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
        
        // Center alignment untuk kolom No
        $sheet->getStyle('A' . $currentRow)->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $currentRow++;
    }

    // === PENGATURAN KOLOM DAN BARIS ===
    
    // Auto size untuk kolom
    $sheet->getColumnDimension('A')->setWidth(8);  // Kolom No
    $sheet->getColumnDimension('B')->setWidth(30); // Kolom Nama

    // Set tinggi baris
    $sheet->getRowDimension(1)->setRowHeight(30);        // Baris judul
    $sheet->getRowDimension($headerRow)->setRowHeight(25); // Baris header

    // === DOWNLOAD FILE ===
    $filename = 'Data_Kategori_Profesi_' . date('Y-m-d_H-i-s') . '.xlsx';
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
}
    
}
