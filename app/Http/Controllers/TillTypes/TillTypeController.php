<?php

namespace App\Http\Controllers\TillTypes;

use App\Models\TillType;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TillTypeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
    {
        //
        $t = TillType::query()->first();
        $query = TillType::query();
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
        //add validation and store for the model
        $rules = [
            'till_type_desc' => 'required|string|max:255',
        ];

        // Validate the request
        $validatedData = $request->validate($rules);

        // Store the model
        $tillType = TillType::create($validatedData);

        // Return a success response
        return $this->showOne($tillType, 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TillType  $tillType
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //add code to show a till type
        $tillType = TillType::find($id);
        return $this->showOne($tillType,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TillType  $tillType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //add code to update a till type
        $validatedData = $request->validate([
            'till_type_desc' => 'required|string|max:255',
        ]);

        // Update the till type
        $tillType = TillType::find($validatedData['id']);
        $tillType->update($validatedData);

        // Return a success response
        return $this->showOne($tillType, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TillType  $tillType
     * @return \Illuminate\Http\Response
     */
    public function destroy(TillType $tillType)
    {
        //add code to delete a till type using findOrFail function that provide the model
        $tillType = TillType::findOrFail($tillType);

        // Delete the till type
        $tillType->delete();

        // Return a success response
        return response()->json('Eliminado con exito');
    }
}
