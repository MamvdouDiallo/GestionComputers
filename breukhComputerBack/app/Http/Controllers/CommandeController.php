<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Traits\HttpResp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CommandeRequest;
use App\Models\ProductSuccursale;
use App\Models\ProduitCommande;
use DateTime;
use Illuminate\Support\Facades\Date;

class CommandeController extends Controller
{
    use HttpResp;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return $this->success(200, "", Commande::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $response = null;
        DB::transaction(function () use ($request, &$response) {
            try {

                $product = Commande::create([
                    'reduction' => $request->remise,
                    'utilisateur_id' => 1,
                    'client' => 1
                ]);
                $succursale_id = null;
                $product_id = null;
                $quant = null;
                foreach ($request->prodChoices as $variable) {
                    $succursale_id = $variable['id_succursale'];
                    $quant = $variable['quantite'];
                    $product_id = $variable['product_id'];
                    ProduitCommande::create([
                        'commande_id' => $product->id,
                        'product_succursale_id' => $variable['id_succursale'],
                        'prix_vente' => $variable['prix'],
                        'quantity' => $variable['quantite'],
                        'reduction' => $request->remise,
                        'totale' => $request->totale,
                        'montantRemise' => $request->montantRemise
                    ]);

                    $transa = ProductSuccursale::where('product_id', $product_id)
                        ->where('succursale_id', $succursale_id)
                        ->first();
                    if ($transa) {
                        $newQuantity = $transa->quantite - $quant;
                        $transa->update(['quantite' => $newQuantity]);
                        $response = $product;
                    } else {
                        $response = ['error' => 'ProductSuccursale not found'];
                    }
                }
            } catch (\Exception $e) {
                $response = ['error' => $e->getMessage()];
            }
        });
        if (isset($response['error'])) {
            return $this->error(500, $response['error']);
        } else {

            return $this->success(200, "", $response);
        }
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
