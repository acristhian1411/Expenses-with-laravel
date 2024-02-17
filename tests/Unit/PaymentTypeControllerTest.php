<?php

namespace Tests\Unit;
use App\Models\PaymentTypes;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class PaymentTypeControllerTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        $paymenttypes = PaymentTypes::factory()->count(3)->create();

        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/paymenttypes');

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos de los países se devuelvan en la respuesta
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                'payment_type_desc',
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
            'payment_type_desc' => $this->faker->word,
        ];
        $response = $this->post('/api/paymenttypes', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);

        $this->assertDatabaseHas('payment_types', $requestData);
    }

     /** @test */
    public function it_fails_to_store_a_paymenttype_with_invalid_data(){
        $data = [
            'payment_type_desc' => '',
        ];

        $response = $this->post('/api/paymenttypes', $data);

        $response->assertStatus(302);
    }
    public function testShow()
    {
        // Crear un país de prueba
        $paymenttype = PaymentTypes::factory()->create();

        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/paymenttypes/' . $paymenttype->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $paymenttype->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $paymenttype = PaymentTypes::factory()->create();

        // Datos de prueba para actualizar el país
        $updatedData = [
            'payment_type_desc' => $this->faker->word,
        ];

        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/paymenttypes/' . $paymenttype->id, $updatedData);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('payment_types', $updatedData);

        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    /** @test */
    public function it_fails_to_update_a_country_with_invalid_data()
    {
        $paymenttype = PaymentTypes::factory()->create();
        // Datos de prueba para actualizar el país
        $updatedData = [
            'payment_type_desc' => '',
        ];
        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/paymenttypes/' . $paymenttype->id, $updatedData);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(302);
    }
    public function testDestroy()
    {
        // Crear un país de prueba
        $paymenttype = PaymentTypes::factory()->create();

        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/paymenttypes/' . $paymenttype->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('payment_types', [
            'id' => $paymenttype->id,
        ]);

        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}