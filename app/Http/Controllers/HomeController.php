<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Questionnaire;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('landingPage.layouts.index',[
			'content' => view('landingPage.index')
		]);
    }

    public function listSurveyIndex()
    {
        $data = Questionnaire::all();

        return view('landingPage.layouts.index',[
            'content' => view('landingPage.list-survey', [
                'data' => $data
            ])
        ]);
    }
    public function aboutIndex()
    {
        return view('landingPage.layouts.index',[
            'content' => view('landingPage.about')
        ]);
    }
}
