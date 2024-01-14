<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Tills;
use App\Models\TillType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class TillsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        $tills = Tills::factory()->count(3)->create();
        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/tills');
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos de los países se devuelvan en la respuesta
        $response->assertJson([
            'data' => $tills->toArray(),
        ]);
    }
    public function testStore()
    {
        $tilltypes = TillType::factory()->count(3)->create();
        $requestData = [
            'till_status' => $this->faker->boolean,
            'till_name' => $this->faker->name,
            'till_account_number' => $this->faker->bankAccountNumber,
            't_type_id' => $tilltypes->random()->id
        ];
        $response = $this->post('/api/tills', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);
        $this->assertDatabaseHas('tills', $requestData);
    }
    public function testShow()
    {
        // Crear un país de prueba
        $till = Tills::factory()->create();
        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/tills/' . $till->id);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $till->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $till = Tills::factory()->create();
        // Datos de prueba para actualizar el país
        // update state_id with existing country
        $tilltypes = TillType::factory()->count(3)->create();
        $newCountryId = $tilltypes->random()->id;
        $tilltypes = TillType::factory()->count(3)->create();
        $updatedData = [
            'till_status' => $this->faker->boolean,
            'till_name' => $this->faker->name,
            'till_account_number' => $this->faker->bankAccountNumber,
            't_type_id' => $tilltypes->random()->id
        ];
        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/tills/' . $till->id, $updatedData);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('tills', $updatedData);
        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $till = Tills::factory()->create();
        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/tills/' . $till->id);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('tills', [
            'id' => $till->id,
        ]);
        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}