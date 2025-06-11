<?php

namespace App\Http\Controllers\Backoffice\Operational;

use App\Http\Controllers\Controller;
use App\Models\Superior;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\SuperiorRequest;
use App\Models\Alumni;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Str;
use Nette\Utils\Random;

class SuperiorsController extends Controller
{
    public function index()
    {
        $is_super = Auth::user()->is_super;

        return view('layouts.index', [
            'title' => 'Atasan Alumni',
            'content' => view('backoffice.superiors.index', compact('is_super'))
        ]);
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $query = Superior::with('company');
            $query->withCount('alumni');

            if ($request->filled('position')) {
                $query->where('position', $request->position);
            }

            if ($request->filled('company')) {
                $query->where('company_id', $request->company);
            }

            $data = $query->get();

            if ($request->filled('is_filled')) {
                $data = $data->filter(function ($item) use ($request) {
                    $getListAlumniSuperior = Alumni::where('superior_id', $item->id)
                        ->select('id')
                        ->pluck('id')
                        ->toArray();

                    foreach ($getListAlumniSuperior as $alumni_id) {
                        $answer = Answer::where('filler_type', 'superior')
                            ->where('filler_id', $item->id)
                            ->where('alumni_id', $alumni_id)
                            ->first();

                        if ($request->is_filled == "filled") {
                            if (!$answer) {
                                return false;
                            }
                        } else if ($request->is_filled == "unfilled") {
                            if ($answer) {
                                return false;
                            }
                        }
                    }

                    return true;
                })->values();
            }


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
    $query = Superior::with('company');

    if (!empty($request->position)) {
        $query->where('position', $request->position);
    }

    if (!empty($request->company)) {
        $query->where('company_id', $request->company);
    }

    $superiors = $query->get();

    if ($request->filled('is_filled')) {
        $superiors = $superiors->filter(function ($item) use ($request) {
            $getListAlumniSuperior = Alumni::where('superior_id', $item->id)
                ->pluck('id')
                ->toArray();

            foreach ($getListAlumniSuperior as $alumni_id) {
                $answer = Answer::where('filler_type', 'superior')
                    ->where('filler_id', $item->id)
                    ->where('alumni_id', $alumni_id)
                    ->first();

                if ($request->is_filled === "filled" && !$answer) {
                    return false;
                } else if ($request->is_filled === "unfilled" && $answer) {
                    return false;
                }
            }

            return true;
        })->values();
    }

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // === BAGIAN HEADER INFORMASI (5 BARIS TERATAS) ===
    
    // Baris 1: Judul utama
    $sheet->setCellValue('A1', 'DATA SUPERIOR');
    $sheet->mergeCells('A1:F1');
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
    $sheet->mergeCells('A2:F2');
    $sheet->getStyle('A2')->applyFromArray([
        'font' => [
            'italic' => true,
            'size' => 10
        ]
    ]);

    // Baris 3: Total data dan filter info
    $filterInfo = 'Total Data: ' . $superiors->count() . ' superior';
    if ($request->filled('position') || $request->filled('company') || $request->filled('is_filled')) {
        $filterInfo .= ' (Terfilter)';
    }
    $sheet->setCellValue('A3', $filterInfo);
    $sheet->mergeCells('A3:F3');
    $sheet->getStyle('A3')->applyFromArray([
        'font' => [
            'size' => 10
        ]
    ]);

    // Baris 4: Informasi filter yang digunakan
    $filterDetails = [];
    if ($request->filled('position')) {
        $filterDetails[] = 'Posisi: ' . $request->position;
    }
    if ($request->filled('company')) {
        // Ambil nama perusahaan berdasarkan ID
        $companyName = \App\Models\Company::find($request->company)?->name ?? 'ID: ' . $request->company;
        $filterDetails[] = 'Perusahaan: ' . $companyName;
    }
    if ($request->filled('is_filled')) {
        $statusText = $request->is_filled === 'filled' ? 'Sudah Mengisi' : 'Belum Mengisi';
        $filterDetails[] = 'Status Pengisian: ' . $statusText;
    }

    if (!empty($filterDetails)) {
        $sheet->setCellValue('A4', 'Filter: ' . implode(', ', $filterDetails));
        $sheet->mergeCells('A4:F4');
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
    $sheet->setCellValue('C' . $headerRow, 'Posisi');
    $sheet->setCellValue('D' . $headerRow, 'Telepon');
    $sheet->setCellValue('E' . $headerRow, 'Email');
    $sheet->setCellValue('F' . $headerRow, 'Perusahaan');

    // Style untuk header dengan background color
    $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)->applyFromArray([
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

    foreach ($superiors as $index => $superior) {
        $sheet->setCellValue('A' . $currentRow, $index + 1);
        $sheet->setCellValue('B' . $currentRow, $superior->full_name);
        $sheet->setCellValue('C' . $currentRow, $superior->position);
        $sheet->setCellValue('D' . $currentRow, $superior->phone);
        $sheet->setCellValue('E' . $currentRow, $superior->email);
        $sheet->setCellValue('F' . $currentRow, $superior->company?->name ?? '-');

        // Style untuk baris data
        $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->applyFromArray([
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
    foreach (range('A', 'F') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Set tinggi baris
    $sheet->getRowDimension(1)->setRowHeight(30);
    $sheet->getRowDimension($headerRow)->setRowHeight(25);

    $sheet->setTitle('Data Superior');
    $filename = 'Data_Superior_' . date('Y-m-d_H-i-s') . '.xlsx';
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
}


    public function showAlumni($id)
    {
        $alumnis = \App\Models\Alumni::where('superior_id', $id)->get(); // pastikan kolom ini ada
        return view('backoffice.superiors.modal_alumni', compact('alumnis'));
    }

    public function sendReminder($id)
    {
        try {
            $superior = Superior::findOrFail($id);

            if (empty($superior->passcode)) {
                $superior->passcode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $superior->save();
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'email' => $superior->email,
                    'name' => $superior->full_name,
                    'passcode' => $superior->passcode,
                    'company_name' => $superior->company->name ?? 'Jurusan Teknologi Informasi Politeknik Negeri Malang'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim reminder: ' . $e->getMessage()
            ], 500);
        }
    }


    public function cardStats(Request $request)
    {
        $result = [
            'count_superior' => 0,
            'count_superior_fill' => 0,
            'count_superior_unfill' => 0,
        ];

        $baseQuery = Superior::query();

        if ($request->filled('position')) {
            $baseQuery->where('position', $request->position);
        }

        if ($request->filled('company_id')) {
            $baseQuery->where('company_id', $request->company_id);
        }

        $superiors = $baseQuery->get();

        $countTotalFiltered = 0;
        $countFilled = 0;
        $countUnfilled = 0;

        foreach ($superiors as $superior) {
            $getListAlumniSuperior = Alumni::where('superior_id', $superior->id)
                ->select('id')
                ->pluck('id')
                ->toArray();

            $isCurrentSuperiorUnfilled = false;
            $isCurrentSuperiorFilled = false;

            if (empty($getListAlumniSuperior)) {
                $isCurrentSuperiorUnfilled = true;
            } else {
                foreach ($getListAlumniSuperior as $alumni_id) {
                    $answer = Answer::where('filler_type', 'superior')
                        ->where('filler_id', $superior->id)
                        ->where('alumni_id', $alumni_id)
                        ->first();

                    if ($answer) {
                        $isCurrentSuperiorFilled = true;
                        break;
                    }
                }

                if (!$isCurrentSuperiorFilled) {
                    $isCurrentSuperiorUnfilled = true;
                }
            }

            if ($request->filled('is_filled')) {
                if ($request->is_filled === 'filled' && !$isCurrentSuperiorFilled) {
                    continue;
                }
                if ($request->is_filled === 'unfilled' && !$isCurrentSuperiorUnfilled) {
                    continue;
                }
            }

            $countTotalFiltered++;

            if ($isCurrentSuperiorFilled) {
                $countFilled++;
            } else {
                $countUnfilled++;
            }
        }

        $result['count_superior'] = $countTotalFiltered;
        $result['count_superior_fill'] = $countFilled;
        $result['count_superior_unfill'] = $countUnfilled;

        return response()->json($result);
    }
}
