<?php

namespace Tests\Unit;
use App\Models\PersonTypes;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class PersonTypesControllerTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        $persontypes = PersonTypes::factory()->count(3)->create();
        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/persontypes');
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos de los países se devuelvan en la respuesta
        $response->assertJson([
            'data' => $persontypes->toArray(),
        ]);
    }
    public function testStore()
    {
        $requestData = [
            'p_type_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        ];
        $response = $this->post('/api/persontypes', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);
        $this->assertDatabaseHas('person_types', $requestData);
    }
    public function testShow()
    {
        // Crear un país de prueba
        $persontype = PersonTypes::factory()->create();
        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/persontypes/' . $persontype->id);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $persontype->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $persontype = PersonTypes::factory()->create();
        // Datos de prueba para actualizar el país
        $updatedData = [
            'p_type_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true)
        ];
        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/persontypes/' . $persontype->id, $updatedData);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('person_types', $updatedData);
        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $persontype = PersonTypes::factory()->create();
        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/persontypes/' . $persontype->id);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('person_types', [
            'id' => $persontype->id,
        ]);
        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}