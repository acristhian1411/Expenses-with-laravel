<?php

namespace App\Http\Controllers\Countries;

use App\Models\Countries;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
class CountriesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $t = Countries::query()->first();
        $query = Countries::query();
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
            'country_name' => 'required|string|max:255',
            'country_code' => 'required|string|max:255',
        ];
        $this->validate($request, $reglas);
        $dato = Countries::create($request->all());
        return $this->showOne($dato, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $dato = Countries::query()->find($id);
        return $this->showOne($dato, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $reglas = [
            'country_name' => 'required|string|max:255',
            'country_code' => 'required|string|max:255',
        ];
        $this->validate($request, $reglas);
        $dato = Countries::query()->find($id);
        $dato->update($request->all());
        return $this->showOne($dato, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $dato = Countries::query()->find($id);
        $dato->delete();
        return response()->json('Eliminado con exito');
    }
}
