<?php

namespace Tests\Unit;
use App\Models\TillType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class TillTypeControllerTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        $tilltypes = TillType::factory()->count(3)->create();

        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/tilltypes');

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos de los países se devuelvan en la respuesta
        $response->assertJson([
            'data' => $tilltypes->toArray(),
        ]);
    }
    public function testStore()
    {
        $requestData = [
            'till_type_desc' => $this->faker->word,
        ];
        $response = $this->post('/api/tilltypes', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);

        $this->assertDatabaseHas('till_types', $requestData);
    }
    public function testShow()
    {
        // Crear un país de prueba
        $tilltype = TillType::factory()->create();

        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/tilltypes/' . $tilltype->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $tilltype->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $tilltype = TillType::factory()->create();

        // Datos de prueba para actualizar el país
        $updatedData = [
            'till_type_desc' => $this->faker->word,
        ];

        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/tilltypes/' . $tilltype->id, $updatedData);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('till_types', $updatedData);

        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $tilltype = TillType::factory()->create();

        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/tilltypes/' . $tilltype->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('till_types', [
            'id' => $tilltype->id,
        ]);

        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}