<?php

namespace App\Http\Controllers\Sales;

use App\Models\Sales;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SalesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $t = Sales::query()->first();
        $query = Sales::query();
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
        $reglas = [
            'person_id' => 'required',
            'sale_desc' => 'required',
            'sale_date' => 'required',
            'sale_number' => 'required',
            'sale_status' => 'required',
            'sale_type' => 'required'
        ];
        $this->validate($request, $reglas);
        $data = $request->all();
        $sales = Sales::create($data);
        return $this->showOne($sales, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $sales = Sales::findOrFail($id);
        return $this->showOne($sales, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $reglas = [
            'person_id' => 'required',
            'sale_desc' => 'required',
            'sale_date' => 'required',
            'sale_number' => 'required',
            'sale_status' => 'required',
            'sale_type' => 'required'
        ];
        $this->validate($request, $reglas);
        $data = $request->all();
        $sales = Sales::findOrFail($id);
        $sales->update($data);
        return $this->showOne($sales, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $sales = Sales::findOrFail($id);
        $sales->delete();
        return response()->json('Eliminado con exito!');
    }
}
