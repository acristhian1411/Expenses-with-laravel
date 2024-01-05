<?php

namespace App\Http\Controllers\TillDetails;

use App\Models\TillDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TillDetailsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $t = TillDetails::query()->first();
        $query = TillDetails::query();
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
            'till_id' => 'required|integer',
            'person_id' => 'required|integer',
            'account_p_id' => 'required|integer',
            'td_desc' => 'required|string|max:255',
            'td_date' => 'required|date',
            'td_type' => 'required|string|max:255',
            'td_amount' => 'required|numeric',
        ];
        
        $this->validate($request, $rules);
        $tillDetails = TillDetails::create($request->all());
        return $this->showOne($tillDetails, 201);
    }

    public function storeFromArray(Request $request){
        // write code to store TillDetails iterating a array obtained from request. Include validation
          
    $tillDetails = collect($request->all())->map(function ($item) {
        return TillDetails::create($item);
    });

    return $this->showAll($tillDetails, 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TillDetails  $tillDetails
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $tillDetails = TillDetails::findOrFail($id);
        return $this->showOne($tillDetails, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TillDetails  $tillDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $tillDetails = TillDetails::findOrFail($id);
        $tillDetails->fill($request->all());
        $tillDetails->save();
        return $this->showOne($tillDetails, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TillDetails  $tillDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
        $tillDetails = TillDetails::findOrFail($id);
        $tillDetails->delete();
        return response()->json('Eliminado con exito');
    }
}
