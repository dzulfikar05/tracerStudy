<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AtasanAlumni;
use App\Models\Superior;

class AtasanAlumniController extends Controller
{
    public function index()
    {
        $data = Superior::with('company:id,name')  // relasi perusahaan
            ->select('id', 'full_name', 'position', 'phone', 'email', 'company_id', 'passcode')
            ->orderBy('full_name')
            ->get();

        return response()->json([
            'status' => true,
            'total'  => $data->count(),
            'data'   => $data
        ], 200);
    }
}
