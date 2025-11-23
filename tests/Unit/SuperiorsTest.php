<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\Backoffice\Operational\SuperiorsController;
use App\Http\Requests\SuperiorRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SuperiorsTest extends TestCase
{
    /** @test */
    public function test_card_stats_return_correct_structure()
    {
        $controller = new SuperiorsController();
        $request = new Request(); // tanpa filter

        $response = $controller->cardStats($request);
        $json = $response->getData(true);

        $this->assertArrayHasKey('count_superior', $json);
        $this->assertArrayHasKey('count_superior_fill', $json);
        $this->assertArrayHasKey('count_superior_unfill', $json);
    }

    /** @test */
    public function test_superior_request_validation_passes()
    {
        $request = new SuperiorRequest();

        $validator = Validator::make([
            'full_name' => 'Budi Santoso',
            'position' => 'Manager',
            'phone' => '081234567890',
            'email' => 'budi@example.com',
            'company_id' => 1
        ], $request->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function test_superior_request_validation_fails_when_name_empty()
    {
        $request = new SuperiorRequest();

        $validator = Validator::make([
            'full_name' => '',
            'position' => 'Supervisor',
            'phone' => '081234567890',
            'email' => 'superior@example.com',
            'company_id' => 1
        ], $request->rules());

        $this->assertTrue($validator->fails());
    }
}
