<?php

namespace App\Http\Controllers\Products;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $t = Products::query()->first();
        $query = Products::query();
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
            'product_name' => 'required|string|max:255',
            'product_desc' => 'nullable|string',
            'product_cost_price' => 'required|numeric|min:0',
            'product_quantity' => 'required|integer|min:0',
            'product_selling_price' => 'required|numeric|min:0',
            'category_id' => 'required|integer',
            'iva_type_id' => 'required|integer',
        ];
        $this->validate($request, $rules);
        $products = Products::create($request->all());
        return $this->showOne($products, 201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $products = Products::findOrFail($id);
        return $this->showOne($products, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $reglas = [
            'product_name' => 'required|string|max:255',
            'product_desc' => 'nullable|string',
            'product_cost_price' => 'required|numeric|min:0',
            'product_quantity' => 'required|integer|min:0',
            'product_selling_price' => 'required|numeric|min:0',
            'category_id' => 'required|integer',
            'iva_type_id' => 'required|integer',
        ];
        $this->validate($request, $reglas);
        $products = Products::findOrFail($id);
        $products->update($request->all());
        return $this->showOne($products, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $products = Products::findOrFail($id);
        $products->delete();
        return response()->json('Eliminado con exito');
    }
}
