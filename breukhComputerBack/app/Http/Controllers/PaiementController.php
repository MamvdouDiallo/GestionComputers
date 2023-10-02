<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Traits\HttpResp;
use Illuminate\Http\Request;

class PaiementController extends Controller
{

    use HttpResp;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(200, "", Paiement::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $paiement = Paiement::create($request->all());
        return $this->success(200, "", $paiement);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
