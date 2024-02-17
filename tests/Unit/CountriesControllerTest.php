<?php

namespace Tests\Unit;
use App\Models\Countries;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CountriesControllerTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        $countries = Countries::factory()->count(3)->create();

        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/countries');

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
            'country_name' => $this->faker->country,
            'country_code' => $this->faker->countryCode,
        ];
        $response = $this->post('/api/countries', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);

        $this->assertDatabaseHas('countries', $requestData);
    }

     /** @test */
    public function it_fails_to_store_a_country_with_invalid_data(){
        $data = [
            'country_name' => '',
            'country_code' => '',
        ];

        $response = $this->post('/api/countries', $data);

        $response->assertStatus(302);
    }
    public function testShow()
    {
        // Crear un país de prueba
        $country = Countries::factory()->create();

        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/countries/' . $country->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $country->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $country = Countries::factory()->create();

        // Datos de prueba para actualizar el país
        $updatedData = [
            'country_name' => 'Updated Country',
            'country_code' => 'UC',
        ];

        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/countries/' . $country->id, $updatedData);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('countries', $updatedData);

        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }
    /** @test */
    public function it_fails_to_update_a_country_with_invalid_data()
    {
        $country = Countries::factory()->create();
        // Datos de prueba para actualizar el país
        $updatedData = [
            'country_name' => 'Updated Country',
            'country_code' => '',
        ];
        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/countries/' . $country->id, $updatedData);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(302);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $country = Countries::factory()->create();

        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/countries/' . $country->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('countries', [
            'id' => $country->id,
        ]);

        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}