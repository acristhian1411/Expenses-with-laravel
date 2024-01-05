<?php

namespace App\Http\Controllers\Categories;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $t = Categories::query()->first();
        $query = Categories::query();
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
            'cat_desc' => 'required|string|max:255',
        ];
        $this->validate($request, $rules);
        $categories = Categories::create($request->all());
        return $this->showOne($categories, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $categories = Categories::findOrFail($id);
        return $this->showOne($categories,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rules = [
            'cat_desc' => 'required|string|max:255',
        ];
        $this->validate($request, $rules);
        $categories = Categories::findOrFail($id);
        $categories->update($request->all());
        return $this->showOne($categories, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $categories = Categories::findOrFail($id);
        $categories->delete();
        return response()->json('Eliminado con exito');
    }
}
