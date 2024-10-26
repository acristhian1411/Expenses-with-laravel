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
        try{
            $t = Persons::query()->first();
            $query = Persons::query();
            $query = $this->filterData($query, $t);
            $datos = $query
            ->join('person_types','person_types.id','=','persons.p_type_id')
            ->join('countries','countries.id','=','persons.country_id')
            ->join('cities','cities.id','=','persons.city_id')
            ->select('persons.*','person_types.p_type_desc','countries.country_name','cities.city_name')
            ->get();
            return $this->showAll($datos, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),
        'message'=>'No se pudo obtener los datos'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
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
            $request->validate($reglas);
            $dato = Persons::create($request->all());
            return response()->json(['message'=>'Registro creado con exito','data'=>$dato]);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),
        'message'=>'No se pudo crear los datos'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Persons  $persons
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $persons = Persons::find($id);
            $audit = $persons->audits;
            return $this->showOne($persons, $audit, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
        }
    }

    //
    public function personByType($id){
        try{
        $persons = Persons::where('p_type_id', $id)->get();
        return $this->showAll($persons, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
        }
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
        try{
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
            $request->validate($reglas);
            $persons = Persons::find($id);
            $persons->update($request->all());
            return response()->json(['message'=>'Registro Actualizado con exito','data'=>$persons]);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo actualizar los datos'],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Persons  $persons
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $persons = Persons::find($id);
            $persons->delete();
            return response()->json('Eliminado con exito');
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo eliminar los datos'],500);
        }
    }
}
