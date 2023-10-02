<?php

namespace App\Http\Controllers;

use App\Http\Requests\AmiRequest;
use App\Models\Ami;
use App\Traits\HttpResp;
use Illuminate\Http\Request;

class AmiController extends Controller
{

    use HttpResp;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(200, "", Ami::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AmiRequest $request)
    {
        $ami = Ami::create($request->all());
        return $this->success(200, "", $ami);
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
