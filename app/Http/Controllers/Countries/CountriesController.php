<?php

namespace App\Http\Controllers\Countries;

use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Iluminate\Validation\ValidationException;
class CountriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $t = Countries::query()->first();
            $query = Countries::query();
            $query = $this->filterData($query, $t);
            $datos = $query
            ->get();
            return $this->showAll($datos, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo obtener los datos']);
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
                'country_name' => 'required|string|max:255',
                'country_code' => 'required|string|max:255',
            ];
            $request->validate( $reglas);
            $dato = Countries::create($request->all());
            return response()->json(['message'=>'Registro creado con exito','data'=>$dato],201);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e,
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }
        catch(\Exception $e){
            return response()->json(['error'=> $e->getMessage(),'message'=>'No se pudo crear registro'],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $dato = Countries::findOrFail($id);
            $audits = $dato->audits;
            // dd($audits);

            return $this->showOne($dato,$audits, 200);
        }
        catch(\Exception $e){
            return response()->json([
                'error'=>$e,
                'mesage'=>'No se pudo obtener los datos'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $reglas = [
                'country_name' => 'required|string|max:255',
                'country_code' => 'required|string|max:255',
            ];
            $request->validate($reglas);
            $dato = Countries::findOrFail($id);
            $dato->update($request->all());
            return response()->json(['message'=>'Registro Actualizado con exito','data'=>$dato],200);
        }catch(\Illuminate\Validation\ValidationException $e){
            // dd($e);
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo actualizar los datos']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $dato = Countries::query()->find($id);
            $dato->delete();
            return response()->json(['message'=>'Eliminado con exito']);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo eliminar los datos']);
        }
    }
}
