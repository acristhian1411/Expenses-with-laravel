<?php

namespace Tests\Unit;

use Tests\TestCase;

class CountriesControllerTest extends TestCase
{
    // use RefreshDatabase;

    public function testStore()
    {
        $requestData = [
            'country_name' => 'Test Country',
            'country_code' => 'TC',
        ];
        $response = $this->post('/api/countries', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'country_name' => 'Test Country',
                    'country_code' => 'TC',
                ],
            ]);

        $this->assertDatabaseHas('countries', $requestData);
    }
}