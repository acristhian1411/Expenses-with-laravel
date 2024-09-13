<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Mockery;
use App\Models\PersonTypes;
use Illuminate\Foundation\Testing\RefreshDatabase;
class PersonTypesTest extends TestCase{
    use RefreshDatabase;
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
        $response = $this->getJson('/api/persontypes');

        // Verificar que el código de respuesta sea 500
        $response->assertStatus(500);

        // Verificar el mensaje de error
        $response->assertJson([
            'error' => 'Test exception',
            'mesage' => 'No se pudo obtener los datos',
        ]);
    }
}
