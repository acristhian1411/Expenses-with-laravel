<?php

namespace App\Http\Controllers\States;

use App\Models\States;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class StatesController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $t = States::query()->first();
        $query = States::query();
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
            'state_name' => 'required',
            'country_id' => 'required',
        ];
        $this->validate($request, $rules);

        $states = States::create($request->all());
        return $this->showOne($states, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\States  $states
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $states = States::findOrFail($id);
        return $this->showOne($states, 200);
    }

    //
    public function getStatesByCountry($id)
    {
        $states = States::where('country_id', $id)->get();
        return $this->showAll($states, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\States  $states
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rules = [
            'state_name' => 'required',
            'country_id' => 'required',
        ];
        $this->validate($request, $rules);
        $states = States::findOrFail($id);
        $states->update($request->all());
        return $this->showOne($states, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\States  $states
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $states = States::findOrFail($id);
        $states->delete();
        return response()->json('Eliminado con exito');
    }
}
