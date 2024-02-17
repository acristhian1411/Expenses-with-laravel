<?php

namespace Tests\Unit;
use App\Models\AccountPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class AccountPlanControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        $accountplans = AccountPlan::factory()->count(3)->create();

        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/accountplans');

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos de los países se devuelvan en la respuesta
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                'city_name',
                'city_code',
                'state_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ],
        ],
        'first_page_url',
        'from',
        'last_page',
        'last_page_url',
        'current_page',
        'links' => [
            '*' => [
                'url',
                'label',
                'active',
            ],
        ],
        'next_page_url',
        'path',
        'per_page',
        'prev_page_url',
        'to',
        'total',
    ]);
    }
    public function testStore()
    {
        $requestData = [
            'account_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'account_code' => $this->faker->word,
        ];
        $response = $this->post('/api/accountplans', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);

        $this->assertDatabaseHas('account_plans', $requestData);
    }
    public function testShow()
    {
        // Crear un país de prueba
        $accountplan = AccountPlan::factory()->create();

        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/accountplans/' . $accountplan->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $accountplan->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $accountplan = AccountPlan::factory()->create();

        // Datos de prueba para actualizar el país
        $updatedData = [
            'account_desc' => 'Updated accountplan',
            'account_code' => 'UC',
        ];

        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/accountplans/' . $accountplan->id, $updatedData);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('account_plans', $updatedData);

        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $accountplan = AccountPlan::factory()->create();

        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/accountplans/' . $accountplan->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('account_plans', [
            'id' => $accountplan->id,
        ]);

        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}