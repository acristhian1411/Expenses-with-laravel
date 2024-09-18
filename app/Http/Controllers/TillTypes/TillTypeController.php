<?php

namespace App\Http\Controllers\TillTypes;

use App\Models\TillType;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TillTypeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
    {
        try{
            $t = TillType::query()->first();
            $query = TillType::query();
            $query = $this->filterData($query, $t);
            $datos = $query->get();
            return $this->showAll($datos, 200);
        }catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=> 'No se pudo obtener los Datos'
            ]);
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
            $rules = [
                'till_type_desc' => 'required|string|max:255',
            ];
            $validatedData = $request->validate($rules);
            $tillType = TillType::create($validatedData);
            return response()->json([
                'message'=>'Registro creado con exito',
                'data'=>$tillType
            ]);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        try{
            $tillType = TillType::find($id);
            $audits = $tillType->audits;
            return $this->showOne($tillType, $audits,200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo obtener los datos']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            $validatedData = $request->validate([
                'till_type_desc' => 'required|string|max:255',
            ]);
            $tillType = TillType::findOrFail($id);
            $tillType->update($validatedData);
            return response()->json([
                'message'=>'Registro actualizado con exito',
                'data'=>$tillType
            ]);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo actualizar los datos']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $tillType = TillType::findOrFail($id);
            $tillType->delete();
            return response()->json(['message'=>'Eliminado con exito']);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'mesage'=>'No se pudo eliminar los datos']);
        }
    }
}
