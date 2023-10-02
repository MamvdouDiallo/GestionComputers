<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuccursaleRequest;
use App\Http\Resources\SuccursaleResource;
use App\Models\Succursale;
use App\Traits\HttpResp;
use Illuminate\Http\Request;

class SuccursaleController extends Controller
{

    use HttpResp;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return $this->success(SuccursaleResource::collection(Succursale::all()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SuccursaleRequest $request)
    {

        $reduction = $request->reduction ?: 0;
        $succursale = Succursale::create([
            'libelle' => $request->libelle,
            'telephone' => $request->telephone,
            'addresse' => $request->addresse,
            'reduction' => $reduction
        ]);
        return $this->success(new SuccursaleResource($succursale));
    }

    /**
     * Display the specified resource.
     */
    public function show(Succursale $succursale)
    {
        return $this->success(new SuccursaleResource($succursale));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
