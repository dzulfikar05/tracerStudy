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
            'title' => 'Pengguna',
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

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // === BAGIAN HEADER INFORMASI (5 BARIS TERATAS) ===
    
    // Baris 1: Judul utama
    $sheet->setCellValue('A1', 'DATA USER');
    $sheet->mergeCells('A1:D1');
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
    $sheet->mergeCells('A2:D2');
    $sheet->getStyle('A2')->applyFromArray([
        'font' => [
            'italic' => true,
            'size' => 10
        ]
    ]);

    // Baris 3: Total data
    $sheet->setCellValue('A3', 'Total Data: ' . $users->count() . ' user');
    $sheet->mergeCells('A3:D3');
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
    $sheet->setCellValue('B' . $headerRow, 'Nama');
    $sheet->setCellValue('C' . $headerRow, 'Email');
    $sheet->setCellValue('D' . $headerRow, 'Tanggal Dibuat');

    // Style untuk header dengan background color
    $sheet->getStyle('A' . $headerRow . ':D' . $headerRow)->applyFromArray([
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

    foreach ($users as $index => $user) {
        $sheet->setCellValue('A' . $currentRow, $index + 1);
        $sheet->setCellValue('B' . $currentRow, $user->name);
        $sheet->setCellValue('C' . $currentRow, $user->email);
        $sheet->setCellValue('D' . $currentRow, $user->created_at ? $user->created_at->format('d-m-Y H:i:s') : '-');
        
        // Style untuk baris data
        $sheet->getStyle('A' . $currentRow . ':D' . $currentRow)->applyFromArray([
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
    $sheet->getColumnDimension('B')->setWidth(25);
    $sheet->getColumnDimension('C')->setWidth(30);
    $sheet->getColumnDimension('D')->setWidth(20);

    // Set tinggi baris
    $sheet->getRowDimension(1)->setRowHeight(30);
    $sheet->getRowDimension($headerRow)->setRowHeight(25);

    $filename = 'Data_User_' . date('Y-m-d_H-i-s') . '.xlsx';
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $filename, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
}
}
