<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Mockery;
use App\Models\PersonTypes;
use OwenIt\Auditing\Models\Audit;

use Illuminate\Foundation\Testing\RefreshDatabase;
class PersonTypesTest extends TestCase{
    public function test_index_returns_person_types()
    {
        // Crear algunos datos de ejemplo
        PersonTypes::factory()->count(3)->create();

        // Realizar la petición a la ruta
        $response = $this->get('/api/persontypes');

        // Verificar que el código de respuesta sea 200 (OK)
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                'p_type_desc',
                'created_at',
                'updated_at',
                'deleted_at',
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
        ],
    ]);

        // Verificar que los datos retornados coincidan con los creados
        $response->assertJsonCount(3, 'data');
    }

    public function test_index_handles_exception()
    {
        // Mock de PersonTypes para forzar una excepción
        $mock = Mockery::mock('overload:' . PersonTypes::class);
        $mock->shouldReceive('query')->andThrow(new \Exception('Test exception'));

        // Llamada al controlador
        $this->app->instance(PersonTypes::class, $mock);
        $response = $this->getJson('/api/persontypes');

        // Verificar que el código de respuesta sea 500
        $response->assertStatus(500);

        // Verificar el mensaje de error
        $response->assertJson([
            'error' => 'Test exception',
            'mesage' => 'No se pudo obtener los datos',
        ]);
    }

    public function test_store_validation_fails()
{
    // Enviar una solicitud sin el campo p_type_desc
    $response = $this->postJson('/api/persontypes', [
        // Se omite el campo requerido p_type_desc para provocar error
    ]);

    // Verificar que el código de respuesta sea 422 (Unprocessable Entity)
    $response->assertStatus(422);

    // Verificar que el error de validación esté presente en la respuesta
    $response->assertJson([
        'message' => 'Los datos no son correctos',
        'error' => 'El campo Descripción es obligatorio.',
        'details' => [
            'p_type_desc' => ['El campo Descripción es obligatorio.'],
        ]
    ]);
}

public function test_store_creates_record_successfully()
{
    // Datos válidos para la solicitud
    $data = [
        'p_type_desc' => 'Test Description'
    ];

    // Enviar la solicitud con datos válidos
    $response = $this->postJson('/api/persontypes', $data);

    // Verificar que el código de respuesta sea 200 (OK)
    $response->assertStatus(200);

    // Verificar que el registro se haya creado correctamente
    $response->assertJson([
        'message' => 'Registro creado con exito',
        'data' => [
            'p_type_desc' => 'Test Description'
        ]
    ]);

    // Verificar que el registro se haya guardado en la base de datos
    $this->assertDatabaseHas('person_types', [
        'p_type_desc' => 'Test Description'
    ]);
}

public function test_store_handles_exception()
{
    // Mock de PersonTypes para forzar una excepción al intentar crear un registro
    $mock = Mockery::mock('overload:' . PersonTypes::class);
    $mock->shouldReceive('create')->andThrow(new \Exception('Test exception'));

    // Enviar una solicitud con datos válidos
    $response = $this->postJson('/api/persontypes', [
        'p_type_desc' => 'Test Description'
    ]);

    // Verificar que el código de respuesta sea 400 (Bad Request)
    $response->assertStatus(400);

    // Verificar que el mensaje de error esté presente en la respuesta
    $response->assertJson([
        'error' => 'Test exception',
        'message' => 'No se pudo crear registro'
    ]);
}

public function test_show_returns_person_type_successfully()
{
    // Crear un registro de prueba con sus auditorías
    $personType = PersonTypes::factory()->create();
    Audit::create([
        'auditable_type' => PersonTypes::class,
        'auditable_id' => $personType->id,
        'event' => 'created',
        'old_values' =>  json_encode([]),
        'new_values' => json_encode(['p_type_desc' => 'New description']),
        'url' => 'http://example.com',
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0',
        'tags' => json_encode([])
    ]);
    // Enviar una solicitud para obtener el registro
    $response = $this->getJson('/api/persontypes/' . $personType->id);

    // Verificar que el código de respuesta sea 200 (OK)
    $response->assertStatus(200);

    // Verificar que el registro y sus auditorías se devuelvan correctamente
    $response->assertJson([
        'data' => [
            'id' => $personType->id,
            'p_type_desc' => $personType->p_type_desc,
        ],
        'audits' => [
            ['event' => 'created'],
        ]
    ]);
}

public function test_show_handles_exception()
{
    // Mock de PersonTypes para forzar una excepción
    $mock = Mockery::mock('overload:' . PersonTypes::class);
    $mock->shouldReceive('find')->andThrow(new \Exception('Test exception'));

    $this->app->instance(PersonTypes::class, $mock);
    // Enviar una solicitud para obtener un registro
    $response = $this->getJson('/api/persontypes/1');

    // Verificar que el código de respuesta sea 500 (Internal Server Error)
    $response->assertStatus(500);

    // Verificar el mensaje de error
    $response->assertJson([
        'error' => 'Test exception',
        'message' => 'No se pudo obtener los datos',
    ]);
}

public function test_update_person_type_successfully()
{
    // Crear un registro de PersonTypes
    $personType = PersonTypes::factory()->create();

    // Datos para la actualización
    $data = ['p_type_desc' => 'Updated description'];

    // Enviar una solicitud para actualizar el registro
    $response = $this->putJson('/api/persontypes/' . $personType->id, $data);

    // Verificar que el código de respuesta sea 200 (OK)
    $response->assertStatus(200);

    // Verificar que el mensaje de éxito y los datos actualizados se devuelvan correctamente
    $response->assertJson([
        'message' => 'Registro Actualizado con exito',
        'data' => [
            'id' => $personType->id,
            'p_type_desc' => 'Updated description',
        ],
    ]);

    // Verificar que el registro se haya actualizado en la base de datos
    $this->assertDatabaseHas('person_types', [
        'id' => $personType->id,
        'p_type_desc' => 'Updated description',
    ]);
}

public function test_update_person_type_validation_error()
{
    // Crear un registro de PersonTypes
    $personType = PersonTypes::factory()->create();

    // Datos para la actualización (sin 'p_type_desc' para provocar un error de validación)
    $data = ['p_type_desc' => '']; // Descripción vacía

    // Enviar una solicitud para actualizar el registro
    $response = $this->putJson('/api/persontypes/' . $personType->id, $data);

    // Verificar que el código de respuesta sea 422 (Unprocessable Entity)
    $response->assertStatus(422);

    // Verificar que se devuelvan los detalles del error de validación
    $response->assertJson([
        'error' => 'El campo Descripción es obligatorio.',
        'message' => 'Los datos no son correctos',
        'details' => [
            'p_type_desc' => ['El campo Descripción es obligatorio.'],
        ],
    ]);
}

public function test_update_person_type_handles_exception()
{
    // Simular una excepción al buscar el registro
    $this->mock(PersonTypes::class, function ($mock) {
        $mock->shouldReceive('findOrFail')->andThrow(new \Exception('Test exception'));
    });

    // Datos para la actualización
    $data = ['p_type_desc' => 'New description'];

    // Enviar una solicitud para actualizar el registro
    $response = $this->putJson('/api/persontypes/999', $data); // ID no válido

    // Verificar que el código de respuesta sea 500 (Internal Server Error)
    $response->assertStatus(500);

    // Verificar el mensaje de error
    $response->assertJson([
        // 'error' => 'Test exception',
        'message' => 'No se pudo actualizar los datos',
    ]);
}

public function test_destroy_person_type_success()
{
    // Configurar un ID de ejemplo y simular el objeto de PersonTypes
    $personType = PersonTypes::factory()->create();

    // Enviar una solicitud para eliminar el recurso
    $response = $this->deleteJson("/api/persontypes/{$personType->id}");

    // Verificar que el código de respuesta sea 200
    $response->assertStatus(200);

    // Verificar el mensaje de éxito
    $response->assertJson(['message' => 'Eliminado con exito']);

    // Comprobar que el registro se haya eliminado
    $this->assertSoftDeleted('person_types', ['id' => $personType->id]);
}

public function test_destroy_person_type_handles_exception()
{
    // Mockear la clase PersonTypes para lanzar una excepción cuando se llama a findOrFail
    $this->mock(PersonTypes::class, function ($mock) {
        $mock->shouldReceive('findOrFail')->andThrow(new \Exception('Test exception'));
    });

    // Enviar una solicitud para eliminar un registro con un ID no válido
    $response = $this->deleteJson('/api/persontypes/999'); // ID no válido

    // Verificar que el código de respuesta sea 500 (Internal Server Error)
    $response->assertStatus(500);

    // Verificar el mensaje de error
    $response->assertJson([
        'message' => 'No se pudo eliminar los datos',
    ]);
}


}
