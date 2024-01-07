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
        //
        $t = SalesDetails::query()->first();
        $query = SalesDetails::query();
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
            'sale_id',
            'product_id',
            'sd_qty',
            'sd_desc',
            'sd_amount',
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        $salesDetails = SalesDetails::create($data);
        return $this->showOne($salesDetails, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalesDetails  $salesDetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $dato = SalesDetails::findOrFail($id);
        return $this->showOne($dato, 200);
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
        //
        $rules = [
            'sale_id',
            'product_id',
            'sd_qty',
            'sd_desc',
            'sd_amount',
        ];
        $this->validate($request, $rules);
        $data = $request->all();
        $salesDetails = SalesDetails::findOrFail($id);
        $salesDetails->update($data);
        return $this->showOne($salesDetails, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalesDetails  $salesDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $salesDetails = SalesDetails::findOrFail($id);
        $salesDetails->delete();
        return response()->json('Eliminado con exito!');
    }
}
