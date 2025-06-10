<?php

namespace App\Http\Controllers\Backoffice\Operational;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlumniRequest;
use App\Models\Alumni;
use App\Models\Company;
use App\Models\Profession;
use App\Models\ProfessionCategory;
use App\Models\Superior;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class AlumniController extends Controller
{
    public function index()
    {
        return view('layouts.index', [
            'title' => 'Alumni',
            'content' => view('backoffice.alumni.index')
        ]);
    }

    public function fetchAllSuperior(Request $request)
    {
        $data = Superior::get();
        return response()->json($data);
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = Alumni::with(
                'company',
                'profession.profession_category',
                'superior'
            );


            if ($request->filled('nim')) {
                $data->where('nim', 'like', '%' . $request->nim . '%');
            }

            if ($request->filled('study_program')) {
                $data->where('study_program', $request->study_program);
            }

            if ($request->filled('study_start_year')) {
                $data->where('study_start_year', $request->study_start_year);
            }

            if ($request->filled('company_id')) {
                $data->where('company_id', $request->company_id);
            }
            if ($request->filled('is_filled') && $request->is_filled == "filled") {
                $data->where('company_id', '!=', null);
                $data->where('start_work_date', '!=', null);
                $data->where('start_work_now_date', '!=', null);
                $data->where('waiting_time', '!=', null);
                $data->where('profession_id', '!=', null);
                $data->where('profession_id', '!=', null);
            }


            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('company_name', function ($row) {
                    return $row->company?->name ?? '';
                })
                ->addColumn('profession_category_name', function ($row) {
                    return $row->profession?->profession_category?->name ?? '';
                })
                ->addColumn('profession_name', function ($row) {
                    return $row->profession?->name ?? '';
                })
                ->addColumn('superior_name', function ($row) {
                    return $row->superior?->name ?? '';
                })
                ->addColumn('graduation_date', function ($row) {
                    return $row->graduation_date ? \Carbon\Carbon::parse($row->graduation_date)->format('d/m/Y') : '';
                })
                ->addColumn('start_work_date', function ($row) {
                    return $row->start_work_date ? \Carbon\Carbon::parse($row->start_work_date)->format('d/m/Y') : '';
                })
                ->addColumn('start_work_now_date', function ($row) {
                    return $row->start_work_now_date ? \Carbon\Carbon::parse($row->start_work_now_date)->format('d/m/Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $btn = ' <div class="dropstart">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" style="z-index: 9999 !important; ">
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

        return view('backoffice.alumni.index');
    }

    public function store(AlumniRequest $request)
    {
        $payload = $request->validated();
        if (!is_null($payload['graduation_date']) && !is_null($payload['start_work_date'])) {
            $payload['waiting_time'] = $this->getWaitingTime($payload['graduation_date'], $payload['start_work_date']);
        }

        $operation = Alumni::insert($payload);
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id)
    {
        $operation = Alumni::with('profession')->find($id);
        return $operation;
    }

    public function update($id, AlumniRequest $request)
    {
        $payload = $request->validated();

        if (!is_null($payload['graduation_date']) && !is_null($payload['start_work_date'])) {
            $payload['waiting_time'] = $this->getWaitingTime($payload['graduation_date'], $payload['start_work_date']);
        }

        $operation = Alumni::where('id', $id)->update($payload);
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id)
    {
        $operation = Alumni::where('id', $id)->delete();

        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }

    public function fetchOption(Request $request)
    {
        $company = Company::get();
        $profession = Profession::get();
        $profession_category = ProfessionCategory::get();
        $superior = Superior::get();
        $prodi = Alumni::getProdi();
        return response()->json([
            'company' => $company,
            'profession' => $profession,
            'profession_category' => $profession_category,
            'superior' => $superior,
            'prodi' => $prodi
        ]);
    }

public function export_excel(Request $request)
{
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Ambil data alumni dengan menerapkan filter yang sama seperti di tabel
    $query = Alumni::with(['company', 'profession.profession_category', 'superior']);

    // Apply filters based on request parameters
    if ($request->filled('nim')) {
        $query->where('nim', 'like', '%' . $request->nim . '%');
    }

    if ($request->filled('study_program')) {
        $query->where('study_program', $request->study_program);
    }

    if ($request->filled('study_start_year')) {
        $query->where('study_start_year', $request->study_start_year);
    }

    if ($request->filled('company_id')) {
        $query->where('company_id', $request->company_id);
    }

    if ($request->filled('is_filled') && $request->is_filled == "filled") {
        $query->where('company_id', '!=', null);
        $query->where('start_work_date', '!=', null);
        $query->where('start_work_now_date', '!=', null);
        $query->where('waiting_time', '!=', null);
        $query->where('profession_id', '!=', null);
    }

    $alumni = $query->get();

    // === BAGIAN HEADER INFORMASI (5 BARIS TERATAS) ===
    
    // Baris 1: Judul utama
    $sheet->setCellValue('A1', 'DATA ALUMNI');
    $sheet->mergeCells('A1:N1');
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
    $sheet->mergeCells('A2:N2');
    $sheet->getStyle('A2')->applyFromArray([
        'font' => [
            'italic' => true,
            'size' => 10
        ]
    ]);

    // Baris 3: Total data dan filter info
    $filterInfo = 'Total Data: ' . $alumni->count() . ' alumni';
    if ($request->filled('nim') || $request->filled('study_program') || $request->filled('study_start_year') || $request->filled('company_id') || $request->filled('is_filled')) {
        $filterInfo .= ' (Terfilter)';
    }
    $sheet->setCellValue('A3', $filterInfo);
    $sheet->mergeCells('A3:N3');
    $sheet->getStyle('A3')->applyFromArray([
        'font' => [
            'size' => 10
        ]
    ]);

    // Baris 4: Informasi filter yang digunakan
    $filterDetails = [];
    if ($request->filled('nim')) {
        $filterDetails[] = 'NIM: ' . $request->nim;
    }
    if ($request->filled('study_program')) {
        $filterDetails[] = 'Program Studi: ' . $request->study_program;
    }
    if ($request->filled('study_start_year')) {
        $filterDetails[] = 'Tahun Mulai: ' . $request->study_start_year;
    }
    if ($request->filled('is_filled') && $request->is_filled == "filled") {
        $filterDetails[] = 'Status: Data Lengkap';
    }
    
    if (!empty($filterDetails)) {
        $sheet->setCellValue('A4', 'Filter: ' . implode(', ', $filterDetails));
        $sheet->mergeCells('A4:N4');
        $sheet->getStyle('A4')->applyFromArray([
            'font' => [
                'size' => 9,
                'italic' => true
            ]
        ]);
    }

    // Baris 5: Kosong untuk spacing
    $sheet->setCellValue('A5', '');

    // === BAGIAN HEADER TABEL (BARIS 6) ===
    $headerRow = 6;
    $sheet->setCellValue('A' . $headerRow, 'No');
    $sheet->setCellValue('B' . $headerRow, 'Nama Lengkap');
    $sheet->setCellValue('C' . $headerRow, 'NIM');
    $sheet->setCellValue('D' . $headerRow, 'Program Studi');
    $sheet->setCellValue('E' . $headerRow, 'Tahun Mulai Studi');
    $sheet->setCellValue('F' . $headerRow, 'Tanggal Lulus');
    $sheet->setCellValue('G' . $headerRow, 'Telepon');
    $sheet->setCellValue('H' . $headerRow, 'Email');
    $sheet->setCellValue('I' . $headerRow, 'Tanggal Mulai Kerja');
    $sheet->setCellValue('J' . $headerRow, 'Tanggal Mulai Pekerjaan Sekarang');
    $sheet->setCellValue('K' . $headerRow, 'Perusahaan');
    $sheet->setCellValue('L' . $headerRow, 'Kategori Profesi');
    $sheet->setCellValue('M' . $headerRow, 'Profesi');
    $sheet->setCellValue('N' . $headerRow, 'Atasan');

    // Style untuk header dengan background color
    $sheet->getStyle('A' . $headerRow . ':N' . $headerRow)->applyFromArray([
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

    foreach ($alumni as $index => $data) {
        $sheet->setCellValue('A' . $currentRow, $index + 1);
        $sheet->setCellValue('B' . $currentRow, $data->full_name);
        $sheet->setCellValue('C' . $currentRow, $data->nim);
        $sheet->setCellValue('D' . $currentRow, $data->study_program);
        $sheet->setCellValue('E' . $currentRow, $data->study_start_year);
        $sheet->setCellValue('F' . $currentRow, $data->graduation_date);
        $sheet->setCellValue('G' . $currentRow, $data->phone);
        $sheet->setCellValue('H' . $currentRow, $data->email);
        $sheet->setCellValue('I' . $currentRow, $data->start_work_date);
        $sheet->setCellValue('J' . $currentRow, $data->start_work_now_date);
        $sheet->setCellValue('K' . $currentRow, $data->company?->name ?? '');
        $sheet->setCellValue('L' . $currentRow, $data->profession?->profession_category?->name ?? '');
        $sheet->setCellValue('M' . $currentRow, $data->profession?->name ?? '');
        $sheet->setCellValue('N' . $currentRow, $data->superior?->full_name ?? '');
        
        // Style untuk baris data
        $sheet->getStyle('A' . $currentRow . ':N' . $currentRow)->applyFromArray([
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
    foreach (range('A', 'N') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Set tinggi baris
    $sheet->getRowDimension(1)->setRowHeight(30);
    $sheet->getRowDimension($headerRow)->setRowHeight(25);

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $filename = 'Data_Alumni_' . date('Y-m-d_H-i-s') . '.xlsx';

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
}

    public function import()
    {
        return view('backoffice.alumni.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_alumni' => ['required', 'mimes:xlsx', 'max:2048']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_alumni');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            $updated = 0;

            foreach ($data as $i => $row) {
                if ($i == 1) continue;

                $nim = $row['B'];
                if (!$nim) continue;

                $date = Date::excelToDateTimeObject($row['D']);
                $graduation_date = $date ? $date->format('Y-m-d') : null;

                $existingAlumni = Alumni::withTrashed()->where('nim', $nim)->first();

                if ($existingAlumni) {
                    if ($existingAlumni->trashed()) {
                        $existingAlumni->restore();
                    }
                    $existingAlumni->update([
                        'study_program'     => $row['A'],
                        'full_name'         => $row['C'],
                        'graduation_date'   => $graduation_date,
                    ]);
                    $updated++;
                    continue;
                }

                $insert[] = [
                    'study_program'     => $row['A'],
                    'nim'               => $nim,
                    'full_name'         => $row['C'],
                    'graduation_date'   => $graduation_date,
                ];
            }

            if (count($insert)) {
                Alumni::insert($insert);
            }

            if (count($insert) || $updated > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data alumni berhasil diimport'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data untuk diimport (mungkin semua NIM sudah ada)'
            ]);
        }
    }

    public function cardStats(Request $request)
    {
        $result = [
            'count_alumni' => 0,
            'count_alumni_fill' => 0,
            'count_alumni_unfill' => 0,
            'count_alumni_avg_waiting_time' => '0 Bulan',
        ];

        $query = Alumni::query();

        if ($request->filled('nim')) {
            $query->where('nim', $request->nim);
        }
        if ($request->filled('study_program')) {
            $query->where('study_program', $request->study_program);
        }
        if ($request->filled('study_start_year')) {
            $query->whereYear('study_start_date', $request->study_start_year);
        }
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }
        if ($request->filled('is_filled')) {
            if ($request->is_filled == '1') {
                $query->whereNotNull('start_work_now_date');
            } elseif ($request->is_filled == '0') {
                $query->whereNull('start_work_now_date');
            }
        }

        $result['count_alumni'] = $query->count();
        $result['count_alumni_fill'] = (clone $query)->whereNotNull('start_work_now_date')->count();
        $result['count_alumni_unfill'] = (clone $query)->whereNull('start_work_now_date')->count();

        $avgWaiting = (clone $query)->whereNotNull('start_work_now_date')->avg('waiting_time');
        $result['count_alumni_avg_waiting_time'] = $avgWaiting ? round($avgWaiting, 2) . ' Bulan' : '0 Bulan';

        return response()->json($result);
    }
}
