<?php

namespace App\Http\Controllers\Refunds;

use App\Models\Refunds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class RefundsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $t = Refunds::query()->first();
            $query = Refunds::query();
            $query = $this->filterData($query, $t);
            $datos = $query->get();
            return $this->showAll($datos, 200);
        }catch(\Exception $e){
            return response()->json([
                'error' => $e,
                'message' => 'No se pudo obtener los registros'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $rules = [
                'sale_id' => 'required',
                'refund_date' => 'required',
                'refund_obs' => 'nullable',
                'refund_status' => 'required',
            ];
            $request->validate($rules);
            $refunds = Refunds::create($request->all());
            return response()->json(['message'=>'Registro creado con exito','data'=>$refunds],201);
        }
        catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
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
     */
    public function show(Refunds $refunds)
    {
        try{
            $refunds = Refunds::findOrFail($refunds->id);
            $audits = $refunds->audits;
            return $this->showOne($refunds,$audits,200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Refunds $refunds)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try{
            $rules = [
                'sale_id' => 'required',
                'refund_date' => 'required',
                'refund_obs' => 'nullable',
                'refund_status' => 'required',
            ];
            $request->validate($rules);
            $refunds = Refunds::findOrFail($id);
            $refunds->update($request->all());
            return response()->json(['message'=>'Registro Actualizado con exito','data'=>$refunds],200);
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
     */
    public function destroy(int $id)
    {
        try{
            $refunds = Refunds::findOrFail($id);
            $refunds->delete();
            return response()->json(['message'=>'Eliminado con exito']);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo eliminar el registro']);
        }
    }
}
