<?php

namespace App\Http\Controllers\IvaTypes;

use App\Models\IvaType;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class IvaTypeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $t = IvaType::query()->first();
        $query = IvaType::query();
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
            'iva_type_desc' => 'required|string|max:255',
            'iva_type_percent' => 'required|numeric',
        ];
        $this->validate($request, $reglas);
        $dato = IvaType::create($request->all());
        return $this->showOne($dato, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IvaType  $ivaType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $ivaType = IvaType::find($id);
        return $this->showOne($ivaType, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IvaType  $ivaType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $reglas = [
            'iva_type_desc' => 'required|string|max:255',
            'iva_type_percent' => 'required|numeric',
        ];
        $this->validate($request, $reglas);
        $dato = IvaType::findOrFail($id);
        $dato->update($request->all());
        return $this->showOne($dato, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IvaType  $ivaType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $dato = IvaType::findOrFail($id);
        $dato->delete();
        return response()->json('Eliminado con exito!');
    }
}
