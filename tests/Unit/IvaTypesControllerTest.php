<?php

namespace Tests\Unit;
use App\Models\IvaType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class IvaTypesControllerTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        $ivatypes = IvaType::factory()->count(3)->create();

        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/ivatypes');

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos de los países se devuelvan en la respuesta
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                'iva_type_desc',
                'iva_type_percent',
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
            "iva_type_desc" => $this->faker->sentence(),
            "iva_type_percent" => $this->faker->randomFloat(2, 0, 100)
        ];
        $response = $this->post('/api/ivatypes', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);

        $this->assertDatabaseHas('iva_types', $requestData);
    }

    /** @test */
    public function it_fails_to_store_a_ivatypes_with_invalid_data(){
        $data = [
            'iva_type_desc' => '',
            'iva_type_percent' => '',
        ];

        $response = $this->post('/api/ivatypes', $data);

        $response->assertStatus(302);
    }
    public function testShow()
    {
        // Crear un país de prueba
        $ivatype = IvaType::factory()->create();

        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/ivatypes/' . $ivatype->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $ivatype->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $ivatype = IvaType::factory()->create();

        // Datos de prueba para actualizar el país
        $updatedData = [
            "iva_type_desc" => $this->faker->sentence(),
            "iva_type_percent" => $this->faker->randomFloat(2, 0, 100)
        ];

        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/ivatypes/' . $ivatype->id, $updatedData);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('iva_types', $updatedData);

        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    /** @test */
    public function it_fails_to_update_a_ivatype_with_invalid_data()
    {
        $ivatype = IvaType::factory()->create();
        // Datos de prueba para actualizar el país
        $updatedData = [
            'iva_type_desc' => 'ivatype updated',
            'iva_type_percent' => '',
        ];
        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/ivatypes/' . $ivatype->id, $updatedData);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(302);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $ivatype = IvaType::factory()->create();

        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/ivatypes/' . $ivatype->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('iva_types', [
            'id' => $ivatype->id,
        ]);

        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito!']);
    }
}