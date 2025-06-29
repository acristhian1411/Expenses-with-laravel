<?php

namespace App\Http\Controllers\IvaTypes;

use App\Models\IvaType;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Http\Requests\IndexRequest;
use Inertia\Inertia;
class IvaTypeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $req)
    {
        try{
            $t = IvaType::query()->first();
            $query = IvaType::query();
            $query = $this->filterData($query, $t);
            $datos = $query->get();
            $from = request()->wantsJson() ? 'api' : 'web';
            return $this->showAll($datos,$from,'IvaTypes/index', 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos']);
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
                'iva_type_desc' => 'required|string|max:255',
                'iva_type_percent' => 'required|numeric',
            ];
            $request->validate($reglas);
            $dato = IvaType::create($request->all());
            $audits = $dato->audits;
            return response()->json(['message'=>'Registro creado con exito','data'=>$dato],201);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e,
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo crear el registro']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IvaType  $ivaType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $ivaType = IvaType::find($id);
            $audits = $ivaType->audits;
            if(request()->wantsJson()){
                return $this->showOne($ivaType,$audits, 200);
            }else{
                return Inertia::render('IvaTypes/show', ['ivaType' => $ivaType,'audits'=>$audits]);
            }
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos']);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IvaType  $ivaType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $reglas = [
                'iva_type_desc' => 'required|string|max:255',
                'iva_type_percent' => 'required|numeric',
            ];
            $request->validate( $reglas);
            $dato = IvaType::findOrFail($id);
            $dato->update($request->all());
            return response()->json(['message'=>'Registro Actualizado con exito','data'=>$dato],200);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo actualizar el registro']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IvaType  $ivaType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $dato = IvaType::findOrFail($id);
            $dato->delete();
            return response()->json(['message'=>'Eliminado con exito!']);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo eliminar el registro']);
        }
    }
}
