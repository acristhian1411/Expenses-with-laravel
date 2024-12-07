
<?php

namespace App\Http\Controllers\Tills;

use App\Models\Tills;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TillsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $t = Tills::query()->first();
            $query = Tills::query();
            $query = $this->filterData($query, $t);
            $datos = $query->join('till_types','tills.t_type_id','=','till_types.id')
            ->select('tills.*','till_types.till_type_desc')
            ->get();
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
                'till_name' => 'required|string|max:255',
                't_type_id' => 'required|integer',
            ];
            $request->validate($rules);
            $tills = Tills::create($request->all());
            return $this->showAfterAction($tills,'create',201);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'Ocurrió un error al procesar los datos.'],500);            
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json([
                'error'=>$e->getMessage(),
                'message'=>'Los datos no son correctos',
                'details' => method_exists($e, 'errors') ? $e->errors() : null 
            ],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tills  $tills
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $till = Tills::findOrFail($id);
            $audits = $till->audits;
            return $this->showOne($till, $audits, 200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos']);            
        }
    }

//
public function getByTypeId($id){
    try{
        $tills = Tills::where('t_type_id', $id)->get();
        return $this->showAll($tills, 200);
    }catch(\Exception $e){
        return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo obtener los datos'],500);
    }
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tills  $tills
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $rules = [
                'till_name' => 'required|string|max:255',
                't_type_id' => 'required|integer',
            ];
            $request->validate($rules);
            $tills = Tills::findOrFail($id);
            $tills->update($request->all());
            return $this->showAfterAction($tills,'update',200);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo actualizar los datos'],500);
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
     * @param  \App\Models\Tills  $tills
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $tills = Tills::findOrFail($id);
            $tills->delete();
            return response()->json(['message'=>'Eliminado con exito']);
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage(),'message'=>'No se pudo eliminar los datos'],500);
        }
    }
}
