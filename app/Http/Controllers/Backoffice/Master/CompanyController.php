<?php

namespace App\Http\Controllers\Backoffice\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class CompanyController extends Controller
{
    public function index()
    {
        return view('layouts.index', [
            'title' => 'Company',
            'content' => view('backoffice.company.index')
        ]);
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::get();

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

        return view('backoffice.company.index');
    }


    public function fetchAll()
    {
        $operation = Company::get();
        return $operation;
    }

    public function store(CompanyRequest $request)
    {

        $params = $request->validated();
        $keyName = strtolower(trim($params['name']));
        $exists = Company::whereRaw('LOWER(TRIM(name)) = ?', [$keyName])->exists();
        if ($exists) {
            return $this->sendResponse(false, 'Perusahaan Sudah Terdaftar', 'Gagal Menambahkan Data');
        }

        $operation = Company::insert($request->validated());
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id)
    {
        $operation = Company::find($id);
        return $operation;
    }

    public function update($id, CompanyRequest $request)
    {
        $operation = Company::where('id', $id)->update($request->validated());
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id)
    {
        $operation = Company::where('id', $id)->delete();

        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }

    public function export_excel()
    {
        $companies = Company::select('name', 'company_type', 'scope', 'address', 'phone')->orderBy('id')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'Tipe Perusahaan');
        $sheet->setCellValue('C1', 'Skala');
        $sheet->setCellValue('D1', 'Alamat');
        $sheet->setCellValue('E1', 'No. Telepon');


        $row = 2;
        foreach ($companies as $company) {
            $companyType = "";
            if ($company->company_type == 'private_company') {
                $companyType = "Perusahaan Swasta";
            } elseif ($company->company_type == 'state-owned_enterprise') {
                $companyType = "BUMN";
            } elseif ($company->company_type == 'higher_education') {
                $companyType = "Perguruan Tinggi";
            } elseif ($company->company_type == 'government_agency') {
                $companyType = "Instansi Pemerintah";
            }

            $scopeLabel = "";
            if ($company->scope == 'local') {
                $scopeLabel = "Lokal";
            } elseif ($company->scope == 'national') {
                $scopeLabel = "Nasional";
            } elseif ($company->scope == 'international') {
                $scopeLabel = "Internasional";
            }

            $sheet->setCellValue('A' . $row, $company->name);
            $sheet->setCellValue('B' . $row, $companyType);
            $sheet->setCellValue('C' . $row, $scopeLabel);
            $sheet->setCellValue('D' . $row, $company->address);
            $sheet->setCellValue('E' . $row, $company->phone);
            $row++;
        }

        $filename = 'Data_Perusahaan_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
