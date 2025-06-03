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
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $btn = ' <div class="dropstart">
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
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'NIM');
        $sheet->setCellValue('D1', 'Program Studi');
        $sheet->setCellValue('E1', 'Tahun Mulai Studi');
        $sheet->setCellValue('F1', 'Tanggal Lulus');
        $sheet->setCellValue('G1', 'Telepon');
        $sheet->setCellValue('H1', 'Email');
        $sheet->setCellValue('I1', 'Tanggal Mulai Kerja');
        $sheet->setCellValue('J1', 'Tanggal Mulai Pekerjaan Sekarang');
        $sheet->setCellValue('K1', 'Perusahaan');
        $sheet->setCellValue('L1', 'Kategori Profesi');
        $sheet->setCellValue('M1', 'Profesi');
        $sheet->setCellValue('N1', 'Atasan');

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
                $query->where('profession_id', '!=', null);
            }

        // Get data after applying filters
        $alumni = $query->get();

        $row = 2;
        foreach ($alumni as $index => $data) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $data->full_name);
            $sheet->setCellValue('C' . $row, $data->nim);
            $sheet->setCellValue('D' . $row, $data->study_program);
            $sheet->setCellValue('E' . $row, $data->study_start_year);
            $sheet->setCellValue('F' . $row, $data->graduation_date);
            $sheet->setCellValue('G' . $row, $data->phone);
            $sheet->setCellValue('H' . $row, $data->email);
            $sheet->setCellValue('I' . $row, $data->start_work_date);
            $sheet->setCellValue('J' . $row, $data->start_work_now_date);
            $sheet->setCellValue('K' . $row, $data->company?->name ?? '');
            $sheet->setCellValue('L' . $row, $data->profession?->profession_category?->name ?? '');
            $sheet->setCellValue('M' . $row, $data->profession?->name ?? '');
            $sheet->setCellValue('N' . $row, $data->superior?->full_name ?? '');
            $row++;
        }

        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Siapkan file untuk diunduh
        $writer = new Xlsx($spreadsheet);
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
}
