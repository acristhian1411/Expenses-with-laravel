<?php

namespace Tests\Unit;
use App\Models\Categories;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class CategoriesControllerTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        $categories = Categories::factory()->count(3)->create();
        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/categories');
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
            'cat_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        ];
        $response = $this->post('/api/categories', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);
        $this->assertDatabaseHas('categories', $requestData);
    }

    /** @test */
    public function it_fails_to_store_a_category_with_invalid_data(){
        $data = [
            'cat_desc' => '',
        ];

        $response = $this->post('/api/categories', $data);

        $response->assertStatus(302);
    }

    public function testShow()
    {
        // Crear un país de prueba
        $category = Categories::factory()->create();
        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/categories/' . $category->id);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $category->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $category = Categories::factory()->create();
        // Datos de prueba para actualizar el país
        $updatedData = [
            'cat_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        ];
        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/categories/' . $category->id, $updatedData);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('categories', $updatedData);
        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    /** @test */
    public function it_fails_to_update_a_country_with_invalid_data()
    {
        $category = Categories::factory()->create();
        // Datos de prueba para actualizar el país
        $updatedData = [
            'cat_desc' => '',
        ];
        // Realizar la solicitud PUT a la ruta de actualización de la categoria
        $response = $this->put('/api/categories/' . $category->id, $updatedData);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(302);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $category = Categories::factory()->create();
        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/categories/' . $category->id);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('categories', [
            'id' => $category->id,
        ]);
        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}