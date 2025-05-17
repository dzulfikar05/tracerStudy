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

class DashboardController extends Controller
{
    public function index()
    {
        return view('layouts.index', [
            'title' => 'Dashboard',
            'content' => view('backoffice.dashboard.index')
        ]);
    }


}
