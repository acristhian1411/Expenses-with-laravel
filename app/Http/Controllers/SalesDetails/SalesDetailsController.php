<?php

namespace App\Http\Controllers\SalesDetails;

use App\Models\SalesDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SalesDetailsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $t = SalesDetails::query()->first();
            $query = SalesDetails::query();
            $query = $this->filterData($query, $t);
            $datos = $query->get();
            return $this->showAll($datos, 200);
        }catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Ocurrió un error mientras se obtenían los datos'
            ],500);
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
                'sale_id',
                'product_id',
                'sd_qty',
                'sd_desc',
                'sd_amount',
            ];
            $request->validate( $rules);
            $data = $request->all();
            $salesDetails = SalesDetails::create($data);
            return $this->showAfterAction($salesDetails,'create', 201);
        }catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Ocurrió un error al crear el registro'
            ],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->errors(),
                'message'=>'Los datos enviados no son correctos',
                'details'=>method_exists($e, 'errors') ? $e->errors() : null
            ],422);
        }
    }

    /**
     * Almacena varios detalles de venta a la vez
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMany(Request $request){
        try{
            $reglas =[
                'details'=>'required:array'
            ];
            $request->validate( $reglas);
            $details = SalesDetails::insert($request->details);
            return $this->showAfterAction([],'create',200);
        }catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Ocurrió un error al crear los registros'
        ]);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->errors(),
                'message'=>'Los datos enviados no son correctos',
                'details'=>method_exists($e, 'errors') ? $e->errors() : null
            ],422);
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesDetails  $salesDetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $dato = SalesDetails::findOrFail($id);
            $audits = $dato->audits;
            return $this->showOne($dato,$audits, 200);
        }catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Ocurrió un error al obtener los datos'
                ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalesDetails  $salesDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $rules = [
                'sale_id',
                'product_id',
                'sd_qty',
                'sd_desc',
                'sd_amount',
            ];
            $request->validate($rules);
            $data = $request->all();
            $salesDetails = SalesDetails::findOrFail($id);
            $salesDetails->update($data);
            return $this->showAfterAction($salesDetails,'update', 200);
        }catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Ocurrió un error al actualizar los datos'
            ],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->errors(),
                'message'=>'Los datos enviados no son correctos',
                'details'=>method_exists($e, 'errors') ? $e->errors() : null
            ],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesDetails  $salesDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $salesDetails = SalesDetails::findOrFail($id);
            $salesDetails->delete();
            return response()->json(['message'=>'Eliminado con exito!']);
        }catch(\Exception $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Ocurrió un error al eliminar los datos'
            ],500);
        }
    }
}
