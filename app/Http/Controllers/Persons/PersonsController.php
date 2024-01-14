<?php

namespace App\Http\Controllers\Persons;

use App\Models\Persons;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PersonsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $t = Persons::query()->first();
        $query = Persons::query();
        $query = $this->filterData($query, $t);
        $datos = $query->get();
        return $this->showAll($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $reglas = [
            'person_fname' => 'required|string|max:255',
            'person_lastname' => 'required|string|max:255',
            'person_corpname' => 'nullable|string|max:255',
            'person_idnumber' => 'required|string|max:50',
            'person_ruc' => 'nullable|string|max:50',
            'person_birtdate' => 'required|date',
            'person_address' => 'required|string|max:255',
            'p_type_id' => 'required|integer',
            'country_id' => 'required|integer',
            'city_id' => 'required|integer',
        ];
        $this->validate($request, $reglas);
        $dato = Persons::create($request->all());
        return $this->showOne($dato, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Persons  $persons
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $persons = Persons::find($id);
        return $this->showOne($persons, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Persons  $persons
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $reglas = [
            'person_fname' => 'required|string|max:255',
            'person_lastname' => 'required|string|max:255',
            'person_corpname' => 'nullable|string|max:255',
            'person_idnumber' => 'required|string|max:50',
            'person_ruc' => 'nullable|string|max:50',
            'person_birtdate' => 'required|date',
            'person_address' => 'required|string|max:255',
            'p_type_id' => 'required|integer',
            'country_id' => 'required|integer',
            'city_id' => 'required|integer',
        ];
        $this->validate($request, $reglas);
        $persons = Persons::find($id);
        $persons->update($request->all());
        return $this->showOne($persons, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Persons  $persons
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $persons = Persons::find($id);
        $persons->delete();
        return response()->json('Eliminado con exito');
    }
}
