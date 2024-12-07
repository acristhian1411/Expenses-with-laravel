<?php

namespace App\Http\Controllers\TillDetails;

use App\Models\TillDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TillDetailsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $t = TillDetails::query()->first();
            $query = TillDetails::query();
            $query = $this->filterData($query, $t);
            $datos = $query->get();
            return $this->showAll($datos, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
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
                'till_id' => 'required|integer',
                'person_id' => 'required|integer',
                'account_p_id' => 'required|integer',
                'td_desc' => 'required|string|max:255',
                'td_date' => 'required|date',
                'td_type' => 'required|string|max:255',
                'td_amount' => 'required|numeric',
            ];
            
            $request->validate($rules);
            $tillDetails = TillDetails::create($request->all());
            return $this->showAfterAction($tillDetails,'create', 201);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo guardar los datos'],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=> 'Ls datos no son correrctos',
                'details'=> method_exists($e, 'errors') ? $e->errors() : null
            ]);
        }
    }

    /**
     * Retrive the amount of money in a specific till from the last close
     * @param int $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function showTillAmount($id){
        try{
            $amount = TillDetails::query()->sum('td_amount')
            ->where('till_id',$id);
            return response()->json(['amount'=>$amount]);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
        }
    }

    public function storeFromArray(Request $request){
        try{
            $tillDetails = collect($request->all())->map(function ($item) {
                return TillDetails::create($item);
            });
            return $this->showAll($tillDetails, 201);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo guardar los datos'],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=> 'Ls datos no son correrctos',
                'details'=> method_exists($e, 'errors') ? $e->errors() : null
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TillDetails  $tillDetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $tillDetails = TillDetails::findOrFail($id);
            $audits = $tillDetails->audits;
            return $this->showOne($tillDetails,$audits, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=> 'Ls datos no son correrctos',
                'details'=> method_exists($e, 'errors') ? $e->errors() : null
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TillDetails  $tillDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $rules = [
                'till_id' => 'required|integer',
            ];
            $request->validate($rules);
            $tillDetails = TillDetails::findOrFail($id);
            $tillDetails->fill($request->all());
            $tillDetails->save();
            return $this->showAfterAction($tillDetails,'create', 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo actualizar los datos'],500);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=> 'Ls datos no son correrctos',
                'details'=> method_exists($e, 'errors') ? $e->errors() : null
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TillDetails  $tillDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        try{
            $tillDetails = TillDetails::findOrFail($id);
            $tillDetails->delete();
            return response()->json('Eliminado con exito');
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo eliminar los datos'],500);
        }
    }
}
