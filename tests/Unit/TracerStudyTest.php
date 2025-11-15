<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\Backoffice\Operational\AlumniController;
use App\Http\Requests\AlumniRequest;
use Illuminate\Support\Facades\Validator;

class TracerStudyTest extends TestCase
{
    public function test_get_waiting_time_is_correct()
    {
        $controller = new AlumniController();

        $result = $controller->getWaitingTime('2023-01-01', '2023-04-01');

        $this->assertEquals('3,0', $result);
    }

    public function test_alumni_request_validation_passes()
    {
        $request = new AlumniRequest();

        $validator = Validator::make([
            'study_program' => 'TI',
            'graduation_date' => '2023-06-01',
            'nim' => '1234567890',
            'full_name' => 'Dzul',
            'study_start_year' => '2020',
        ], $request->rules());

        $this->assertFalse($validator->fails());
    }

    public function test_nim_too_long_fails_validation()
    {
        $request = new AlumniRequest();

        $validator = Validator::make([
            'study_program' => 'TI',
            'graduation_date' => '2023-06-01',
            'nim' => '1234567890123', // terlalu panjang
            'full_name' => 'Dzul',
            'study_start_year' => '2020',
        ], $request->rules());

        $this->assertTrue($validator->fails());
    }
}
