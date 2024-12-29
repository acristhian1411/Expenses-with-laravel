<?php

namespace App\Http\Controllers\TillsTransfers;

use App\Models\TillsTransfer;
use Illuminate\Http\Request;

use App\Http\Controllers\ApiController;


class TillsTransfersController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $tillsTransfers = TillsTransfer::all();
            return $this->showAll($tillsTransfers);
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage(), 500);
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
                'origin_id' => 'required',
                'destiny_id' => 'required',
                't_transfer_amount' => 'required',
                't_transfer_date' => 'required',
                't_transfer_obs' => 'required',
            ];
            $request->validate($rules);
            $tillsTransfer = TillsTransfer::create($request->all());
            return $this->showAfterAction($tillsTransfer,'create',201);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage(),'message'=>'Ocurrió un error mientras se guardaban los datos'], 500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(TillsTransfer $id)
    {
        try{
            $data = TillsTransfer::findOrFail($id);
            $audits = $data->audits;
            return $this->showOne($data,$audits,200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
        }
    }

    /**
     * get transfers filtered by till_id and a range of dates
     * @param  \Illuminate\Http\Request  $request
     * @param int $till_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByTillIdAndDate(Request $request, $till_id){
        try{
            $tillsTransfers = TillsTransfer::join('tills as o','o.id','tills_transfers.origin_id')
            ->join('tills as d','d.id','tills_transfers.destiny_id')
            ->where('origin_id', $till_id)
            ->orWhere('destiny_id', $till_id)
            ->select('tills_transfers.*','o.till_name as origin_name','d.till_name as destiny_name')
            ->get();
            return $this->showAll($tillsTransfers);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try{
            $rules = [
                'origin_id' => 'required',
                'destiny_id' => 'required',
                't_transfer_amount' => 'required',
                't_transfer_date' => 'required',
                't_transfer_obs' => 'required',
            ];
            $request->validate($rules);
            $tillsTransfer = TillsTransfer::findOrFail($id);
            $tillsTransfer->update($request->all());
            return $this->showAfterAction($tillsTransfer,'update',200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'Ocurrió un error mientras se actualizaban los datos'],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
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
            $tillsTransfer = TillsTransfer::findOrFail($id);
            $tillsTransfer->delete();
            return response()->json(['message'=>'Datos eliminados correctamente'],200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'Ocurrió un error mientras se eliminaban los datos'],500);
        }
    }
}
