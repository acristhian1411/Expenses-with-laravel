<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\States;
use App\Models\Countries;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class StatesControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        
        $states = States::factory()->count(3)->create();

        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/states');

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos de los países se devuelvan en la respuesta
        $response->assertJson([
            'data' => $states->toArray(),
        ]);
    }
    public function testStore()
    {
        $countries = Countries::factory()->count(3)->create();

        $requestData = [
            'state_name' => $this->faker->state,
            'country_id' => $countries->random()->id,
        ];
        
        $response = $this->post('/api/states', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);

        $this->assertDatabaseHas('states', $requestData);
    }
    public function testShow()
    {
        // Crear un país de prueba
        $state = States::factory()->create();

        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/states/' . $state->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $state->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $state = States::factory()->create();

        // Datos de prueba para actualizar el país
        // update country_id with existing country
        $countries = Countries::factory()->count(3)->create();

        $newCountryId = $countries->random()->id;
        $updatedData = [
            'state_name' => 'Updated Country',
            'country_id' => $newCountryId,
        ];

        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/states/' . $state->id, $updatedData);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('states', $updatedData);

        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $state = States::factory()->create();

        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/states/' . $state->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('states', [
            'id' => $state->id,
        ]);

        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}