<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ProofPayments;
use App\Models\PaymentTypes;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ProofPaymentsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        $proofpayments = ProofPayments::factory()->count(3)->create();
        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/proofpaypments');
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos de los países se devuelvan en la respuesta
        $response->assertJson([
            'data' => $proofpayments->toArray(),
        ]);
    }
    public function testStore()
    {
        $payment_types = PaymentTypes::factory()->create();
        $requestData = [
            'proof_payment_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'payment_type_id' => $payment_types->id,
        ];
        $response = $this->post('/api/proofpaypments', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);
        $this->assertDatabaseHas('proof_payments', $requestData);
    }

    public function testStoreMultiple()
{
    $paymentTypes = PaymentTypes::factory()->create();
    
    $requestData1 = [
        'proof_payment_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        'payment_type_id' => $paymentTypes->id,
    ];

    $requestData2 = [
        'proof_payment_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        'payment_type_id' => $paymentTypes->id,
    ];

    $requestDataArray = [$requestData1, $requestData2];
    
    $response = $this->post('/api/proofpaypments_multiple', $requestDataArray);
    
    $response->assertStatus(200)
        ->assertJson([
            'data' => $requestDataArray,
        ]);

    $this->assertDatabaseHas('proof_payments', $requestData1);
    $this->assertDatabaseHas('proof_payments', $requestData2);
}

    public function testShow()
    {
        // Crear un país de prueba
        $payment_type = ProofPayments::factory()->create();
        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/proofpaypments/' . $payment_type->id);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $payment_type->toArray(),
        ]);
    }

    public function testShowByType()
    {
        // Crear un país de prueba
        $proofpayment = ProofPayments::factory()->count(3)->create();
        $paymentType = PaymentTypes::inRandomOrder()->first();
        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/proofpaypments_type/' . $paymentType->id);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        if($response['data'] == []){
            $response->assertJson([
                'data' => [],
            ]);
        }else{
            $response->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                    'proof_payment_desc',
                    'payment_type_id',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'payment_type_desc',
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
    }
    public function testUpdate()
    {
        // Crear un país de prueba
        $payment_type = ProofPayments::factory()->create();
        $payment_types = PaymentTypes::factory()->create();
        $updatedData = [
            'proof_payment_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'payment_type_id' => $payment_types->id,
        ];
        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/proofpaypments/' . $payment_type->id, $updatedData);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('proof_payments', $updatedData);
        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $payment_type = ProofPayments::factory()->create();
        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/proofpaypments/' . $payment_type->id);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('proof_payments', [
            'id' => $payment_type->id,
        ]);
        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}