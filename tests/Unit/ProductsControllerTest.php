<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Products;
use App\Models\Categories;
use App\Models\IvaType;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    public function testIndex()
    {
        // Crear algunos datos de prueba
        
        $products = Products::factory()->count(3)->create();

        // Realizar la solicitud GET a la ruta del índice
        $response = $this->get('/api/products');

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos de los países se devuelvan en la respuesta
        $response->assertJson([
            'data' => $products->toArray(),
        ]);
    }
    public function testStore()
    {
        $categories = Categories::factory()->count(3)->create();
        $ivatypes = IvaType::factory()->count(3)->create();
        $requestData = [
            'product_name' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'product_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'product_cost_price' => $this->faker->randomFloat(2, 0, 100),
            'product_quantity' => $this->faker->randomDigitNotNull(),
            'product_selling_price' => $this->faker->randomFloat(2, 0, 100),
            'category_id' => $categories->random()->id, 
            'iva_type_id' => $ivatypes->random()->id, 
        ];
        
        $response = $this->post('/api/products', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);

        $this->assertDatabaseHas('products', $requestData);
    }
    public function testShow()
    {
        // Crear un país de prueba
        $product = Products::factory()->create();

        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/products/' . $product->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $product->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $product = Products::factory()->create();
        $categories = Categories::factory()->count(3)->create();
        $ivatypes = IvaType::factory()->count(3)->create();
        $newCategoryId = $categories->random()->id;
        $newIvaTypesId = $ivatypes->random()->id;
        $updatedData = [
            'product_name' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'product_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'product_cost_price' => $this->faker->randomFloat(2, 0, 100),
            'product_quantity' => $this->faker->randomDigitNotNull(),
            'product_selling_price' => $this->faker->randomFloat(2, 0, 100),
            'category_id' => $newCategoryId,
            'iva_type_id' => $newIvaTypesId,
        ];
        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/products/' . $product->id, $updatedData);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('products', $updatedData);
        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $product = Products::factory()->create();

        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/products/' . $product->id);

        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('products', [
            'id' => $product->id,
        ]);

        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}