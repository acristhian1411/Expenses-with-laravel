<?php

namespace App\Http\Controllers\RefundDetails;

use App\Http\Controllers\ApiController;
use App\Models\RefundDetails;
use Illuminate\Http\Request;

class RefundDetailsController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $t = RefundDetails::query()->first();
            $query = RefundDetails::query();
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
                'refund_id' => 'required',
                'product_id' => 'required',
                'quantity' => 'required',
            ];
            $request->validate($rules);
            $refundDetails = RefundDetails::create($request->all());
            return response()->json(['message'=>'Registro creado con exito','data'=>$refundDetails],201);
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

    public function storeMany(Request $request){
        try{
            $rules = [
                'details'=> 'required:array'
            ];
            $request->validate($rules);
            $details = RefundDetails::insert($request->details);
            $algo = [];
            return $this->showAfterAction($algo,'create', 201);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage(), 'message'=>'Ocurrió un error mientras se creaba el registro'],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try{
            $refundDetails = RefundDetails::findOrFail($id);
            $audits = $refundDetails->audits;
            return $this->showOne($refundDetails,$audits,200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RefundDetails $refundDetails)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try{
            $rules = [
                'refund_id' => 'required',
                'product_id' => 'required',
                'quantity' => 'required',
            ];
            $request->validate($rules);
            $refundDetails = RefundDetails::findOrFail($id);
            $refundDetails->update($request->all());
            return response()->json(['message'=>'Registro Actualizado con exito','data'=>$refundDetails],200);
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
            $refundDetails = RefundDetails::findOrFail($id);
            $refundDetails->delete();
            return response()->json(['message'=>'Eliminado con exito']);
        }
        catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo eliminar el registro']);
        }
    }
}
