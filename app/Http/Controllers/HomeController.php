<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Answer;
use App\Models\Company;
use App\Models\Profession;
use App\Models\ProfessionCategory;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Superior;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('landingPage.layouts.index', [
            'content' => view('landingPage.index')
        ]);
    }

    public function listQuestionnaireIndex()
    {
        $data = Questionnaire::where('is_active', true)->get();
        return view('landingPage.layouts.index', [
            'content' => view('landingPage.list-questionnaire', [
                'data' => $data
            ])
        ]);
    }

    public function aboutIndex()
    {
        return view('landingPage.layouts.index', [
            'content' => view('landingPage.about')
        ]);
    }

    public function showQuestionnaireById($id)
    {
        session(['code_validation' => false]);

        $questionnaire = Questionnaire::with('questions')->find($id);
        return view('landingPage.layouts.index', [
            'content' => view('landingPage.validate-questionnaire', [
                'questionnaire' => $questionnaire
            ])
        ]);
    }

    public function fetchOption(Request $request)
    {
        $prodi = Alumni::getProdi();
        $company = Company::get();
        $profession = Profession::get();
        $profession_category = ProfessionCategory::get();

        return response()->json([
            'prodi' => $prodi,
            'company' => $company,
            'profession' => $profession,
            'profession_category' => $profession_category
        ]);
    }

    public function validateAlumni(Request $request)
    {
        $params = $request->all();
        $status = true;
        $code = "";
        $alumni = Alumni::where('nim', $params['nim'])->first();
        if (!isset($alumni)) {
            $status = false;
        } else {
            if ($alumni->graduation_date != $params['graduation_date'] && $alumni->study_program != $params['study_program']) {
                $status = false;
                session(['code_validation' => false]);
            } else {
                $code = str_replace('-', '', $alumni->nim . $alumni->graduation_date . $alumni->id);
                session(['code_validation' => $code]);
            }
        }

        return [
            'success' => $status,
            'title' => $status == true ? 'Success' : 'Failed',
            'message' => $status == true ? 'Data Alumni Berhasil Di Validasi' : 'Data Alumni Tidak Ditemukan',
        ];
    }

    public function contentQuestionnaire($id)
    {
        $code = session('code_validation');

        if (is_null($code)) {
            return redirect()->route('questionnaire.show', $id);
        }

        $questionnaire = Questionnaire::with('questions')->find($id);
        $idUser = substr($code, -1);

        $data = [
            'questionnaire' => $questionnaire,
            'type' => $questionnaire->type,
            'questions' => $questionnaire?->questions ?? [],
        ];

        if ($questionnaire->type == "alumni") {
            $data['alumni'] =  Alumni::with(
                'profession',
                'superior',
            )->find($idUser);
        } else {
            $data['superior'] = Superior::find($idUser);
        }

        return view('landingPage.layouts.index', [
            'content' => view('landingPage.content-questionnaire', [
                'data' => $data,
                'isTrue' => !is_null($code)
            ])
        ]);
    }

    public function storeAlumni(Request $request)
    {
        $code = session('code_validation');
        if (is_null($code)) {
            return redirect()->route('index');
        }

        try {
            DB::commit();


            $params = $request->all();
            $paramsAlumni = $params['alumni'];
            $paramsSuperior = $params['superior'];

            $paramsSuperior['company_id'] = $paramsAlumni['company_id'];
            $paramsAnswer = [];

            foreach ($params['answers'] as $key => $value) {
                $paramsAnswer[] = [
                    'filler_type' => "alumni",
                    'filler_id' => $params['alumni_id'],
                    'questionnaire_id' => $params['questionnaire_id'],
                    'question_id' => $key,
                    'answer' => $value,
                ];
            }

            $checkSuperior = Superior::where('email', $paramsSuperior['email'])->first();

            $superior= null;
            if(isset($checkSuperior)) {
                $superior = $checkSuperior;
            }else{
                $superior = Superior::create($paramsSuperior);
            }

            $paramsAlumni['superior_id'] = $superior->id;
            $alumni = Alumni::find($params['alumni_id'])->update($paramsAlumni);
            $answer = Answer::insert($paramsAnswer);

            DB::commit();

            return [
                'success' => true,
                'title' => 'Success',
                'message' => 'Data Kuisioner Berhasil di Simpan ',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'title' => 'Failed',
                'message' => 'Data Kuisioner Gagal di Simpan',
            ];
        }
    }
}
