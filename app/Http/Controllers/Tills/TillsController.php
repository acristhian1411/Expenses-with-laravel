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
        //
        $t = Tills::query()->first();
        $query = Tills::query();
        $query = $this->filterData($query, $t);
        $datos = $query->get();
        return $this->showAll($datos, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'till_name' => 'required|string|max:255',
            'till_account_number' => 'required|string|max:255',
            't_type_id' => 'required|integer',
        ];
        $this->validate($request, $rules);
        $tills = Tills::create($request->all());
        return $this->showOne($tills, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tills  $tills
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $till = Tills::findOrFail($id);
        return $this->showOne($till, 200);
    }

//
public function getByTypeId($id){
    $tills = Tills::where('t_type_id', $id)->get();
    return $this->showAll($tills, 200);
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
        //
        $rules = [
            'till_name' => 'required|string|max:255',
            'till_account_number' => 'required|string|max:255',
            't_type_id' => 'required|integer',
        ];
        $this->validate($request, $rules);
        $tills = Tills::findOrFail($id);
        $tills->update($request->all());
        return $this->showOne($tills, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tills  $tills
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tills = Tills::findOrFail($id);
        $tills->delete();
        return response()->json('Eliminado con exito');
    }
}
