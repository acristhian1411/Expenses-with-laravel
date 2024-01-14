<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Persons;
use App\Models\PersonTypes;
use App\Models\Countries;
use App\Models\Cities;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class PersonsControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
    public function testIndex()
    {
        $persons = Persons::factory()->count(3)->create();
        $response = $this->get('/api/persons');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => $persons->toArray(),
        ]);
    }
    public function testStore()
    {
        $personTypes = PersonTypes::factory()->create();
        $countries = Countries::factory()->create();
        $cities = Cities::factory()->create();
        $requestData = [
            'person_fname' => $this->faker->firstName(),
            'person_lastname' => $this->faker->lastName(),
            'person_corpname' => $this->faker->name(),
            'person_idnumber' => strval($this->faker->randomNumber()),
            'person_ruc' => strval($this->faker->randomNumber()),
            'person_birtdate' => $this->faker->date(),
            'person_photo' => strval($this->faker->imageUrl()),
            'person_address' => $this->faker->address(),
            'country_id' => $countries->id,
            'city_id' => $cities->id,
            'p_type_id' => $personTypes->id,
        ];
        $response = $this->post('/api/persons', $requestData);
        $response->assertStatus(201)
            ->assertJson([
                'data' => $requestData,
            ]);
        $this->assertDatabaseHas('persons', $requestData);
    }
    public function testShow()
    {
        // Crear un país de prueba
        $person = Persons::factory()->create();
        // Realizar la solicitud GET a la ruta del detalle del país
        $response = $this->get('/api/persons/' . $person->id);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $person->toArray(),
        ]);
    }

    public function testUpdate()
    {
        // Crear un país de prueba
        $person = Persons::factory()->create();
        $personTypes = PersonTypes::factory()->count(3)->create();
        $countries = Countries::factory()->count(3)->create();
        $cities = Cities::factory()->count(3)->create();
        $updatedData = [
            'person_fname' => $this->faker->firstName(),
            'person_lastname' => $this->faker->lastName(),
            'person_corpname' => $this->faker->name(),
            'person_idnumber' => strval($this->faker->randomNumber()),
            'person_ruc' => strval($this->faker->randomNumber()),
            'person_birtdate' => $this->faker->date(),
            'person_photo' => $this->faker->imageUrl(),
            'person_address' => $this->faker->address(),
            'p_type_id' => $personTypes->random()->id,
            'country_id' => $countries->random()->id,
            'city_id' => $cities->random()->id,
        ];
        // Realizar la solicitud PUT a la ruta de actualización del país
        $response = $this->put('/api/persons/' . $person->id, $updatedData);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que los datos del país se hayan actualizado correctamente
        $this->assertDatabaseHas('persons', $updatedData);
        // Verificar que los datos actualizados del país se devuelvan en la respuesta
        $response->assertJson([
            'data' => $updatedData,
        ]);
    }

    public function testDestroy()
    {
        // Crear un país de prueba
        $person = Persons::factory()->create();
        // Realizar la solicitud DELETE a la ruta de eliminación del país
        $response = $this->delete('/api/persons/' . $person->id);
        // Verificar que la respuesta sea exitosa
        $response->assertStatus(200);
        // Verificar que el país haya sido "eliminado" (soft deleted) de la base de datos
        $this->assertSoftDeleted('persons', [
            'id' => $person->id,
        ]);
        // Verificar que el mensaje de éxito se devuelva en la respuesta
        $response->assertExactJson(['Eliminado con exito']);
    }
}