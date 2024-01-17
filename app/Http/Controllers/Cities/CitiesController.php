<?php

namespace App\Http\Controllers\Cities;

use App\Models\Cities;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
class CitiesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $t = Cities::query()->first();
        $query = Cities::query();
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
        $rules=[
            'city_name' => 'required|string|max:255',
            'city_code' => 'required|string|max:255',
            'state_id' => 'required|int',
        ];
        $this->validate($request, $rules);
        $cities = Cities::create($request->all());
        return $this->showOne($cities, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cities = Cities::find($id);
        return $this->showOne($cities,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rules=[
            'city_name' => 'required|string|max:255',
            'city_code' => 'required|string|max:255',
            'state_id' => 'required|int',
        ];
        $this->validate($request, $rules);
        $cities = Cities::find($id);
        $cities->fill($request->all());
        $cities->save();
        return $this->showOne($cities, 201);
    }

    //add function to get cities by state_id
    public function cityByStateId($id){
        $cities = Cities::where('state_id', $id)->get();
        return $this->showAll($cities, 200);
    }

    //add function to get cities by country_id
    public function cityByCountryId($id){
        $cities = Cities::join('states','states.id','=','cities.state_id')
        ->where('states.country_id', $id)->get();
        return $this->showAll($cities, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cities = Cities::find($id);
        $cities->delete();
        return response()->json('Eliminado con exito');
    }
}
