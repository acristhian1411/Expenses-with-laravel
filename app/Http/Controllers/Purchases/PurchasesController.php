<?php

namespace App\Http\Controllers;

use App\Models\Purchases;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $t = Purchases::query()->first();
        $query = Purchases::query();
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
            'purchase_desc' => 'required',
            'purchase_date' => 'required',
            'purchase_number' => 'required',
            'purchase_status' => 'required',
            'purchase_type' => 'required'
        ];
        $this->validate($request, $reglas);
        $purchases = Purchases::create($request->all());
        return $this->showOne($purchases, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $purchases = Purchases::find($id);
        return $this->showOne($purchases, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $reglas = [
            'person_id' => 'required',
            'purchase_desc' => 'required',
            'purchase_date' => 'required',
            'purchase_number' => 'required',
            'purchase_status' => 'required',
            'purchase_type' => 'required'
        ];
        $this->validate($request, $reglas);
        $purchases = Purchases::find($id);
        $purchases->update($request->all());
        return $this->showOne($purchases, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchases  $purchases
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $purchases = Purchases::find($id);
        $purchases->delete();
        return response()->json('Eliminado con exito!');
    }
}
