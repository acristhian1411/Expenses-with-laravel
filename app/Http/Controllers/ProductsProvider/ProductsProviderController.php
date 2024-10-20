<?php

namespace App\Http\Controllers\ProductsProvider;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\ProductsProvider;
class ProductsProviderController extends ApiController
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $t = ProductsProvider::query()->first();
            $query = ProductsProvider::query();
            $query = $this->filterData($query, $t);
            $datos = $query->get();
            return $this->showAll($datos, 200);
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
            $rules = [
                'product_id' => 'required|integer',
                'provider_id' => 'required|integer',
            ];
            $request->validate($rules);
            $ProductsProvider = ProductsProvider::create($request->all());
            return response()->json(['message'=>'Registro creado con exito','data'=>$ProductsProvider],201);
        }
        catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e,
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ], 422);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo crear el registro']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductsProvider  $ProductsProvider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $ProductsProvider = ProductsProvider::findOrFail($id);
            $audits = $ProductsProvider->audits;
            return $this->showOne($ProductsProvider,$audits,200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductsProvider  $ProductsProvider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $rules = [
                'product_id' => 'required|integer',
                'provider_id' => 'required|integer',
            ];
            $request->validate($rules);
            $ProductsProvider = ProductsProvider::findOrFail($id);
            $ProductsProvider->update($request->all());
            return response()->json(['message'=>'Registro Actualizado con exito','data'=>$ProductsProvider],200);
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
     * @param  \App\Models\ProductsProvider  $ProductsProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $ProductsProvider = ProductsProvider::findOrFail($id);
            $ProductsProvider->delete();
            return response()->json(['message'=>'Eliminado con exito']);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo eliminar el registro']);
        }
    }
}
