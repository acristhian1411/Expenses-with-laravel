<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Cities;
use App\Models\States;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CitiesControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        
        $states = Cities::factory()->count(3)->create();

        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/cities');

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos de los países se devuelvan en la respuesta
        $response->assertJson([
            'data' => $states->toArray(),
        ]);
    }
    public function testStore()
    {
        $states = States::factory()->count(3)->create();

        $requestData = [
            'city_name' => $this->faker->city,
            'city_code' => $this->faker->postcode,
            'state_id' => $states->random()->id,
        ];
        
        $response = $this->post('/api/cities', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);

        $this->assertDatabaseHas('cities', $requestData);
    }
    public function testShow()
    {
        // Crear un país de prueba
        $city = Cities::factory()->create();

        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/cities/' . $city->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $city->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $city = Cities::factory()->create();

        // Datos de prueba para actualizar el país
        // update state_id with existing country
        $states = States::factory()->count(3)->create();

        $newCountryId = $states->random()->id;
        $updatedData = [
            'city_name' => $this->faker->city,
            'city_code' => $this->faker->postcode,
            'state_id' => $newCountryId,
        ];

        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/cities/' . $city->id, $updatedData);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(201);

        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('cities', $updatedData);

        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $city = Cities::factory()->create();

        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/cities/' . $city->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('cities', [
            'id' => $city->id,
        ]);

        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}