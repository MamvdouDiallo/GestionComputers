<?php

namespace App\Http\Controllers;

use App\Models\Ami;
use App\Traits\Upload;
use App\Models\Product;
use App\Traits\HttpResp;
use Illuminate\Http\Request;
use App\Models\ProductSuccursale;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use App\Models\CaracteristiqueProduct;
use App\Models\CaracteristiqueProduit;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResource2;
use App\Http\Resources\ProductResource21;
use App\Http\Resources\ProductSuccursaleResource;

class ProductController extends Controller
{

    use HttpResp;
    use Upload;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $votreId = 1;
        $product = Product::with('caracteristiques')
            ->whereHas('productSuccursales', function ($query) use ($votreId) {
                $query->where('succursale_id', $votreId);
            })->get();
        $succursale = ProductSuccursale::where('succursale_id', $votreId)
            ->where('product_id', $product[0]->id)
            ->first();
        $product->each(function ($product) use ($succursale) {
            $product->details = $succursale;
        });
        $data = [
            "product" =>  ProductResource::collection($product),
            "succursales" =>  []
        ];
        return $this->success(200, '', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(ProductRequest $request)
    // {

    //     $response = null;
    //     DB::transaction(function () use ($request, &$response) {
    //         try {
    //             $libelle = $request->libelle;
    //             $libelle =  ucfirst(strtolower($libelle));
    //             $reduction = $request->reduction ?: 0;
    //             $file = $request->file('photo');
    //             $this->uploads($file);
    //             $product = Product::create([
    //                 'libelle' => $libelle,
    //                 'code' => $request->code,
    //                 'reduction' => $reduction,
    //                 'photo' =>  $this->uploads($file),
    //             ]);
    //             ProductSuccursale::create([
    //                 'succursale_id' => $request->succursale_id,
    //                 'product_id' => $product->id,
    //                 'prixDetail' => $request->prixDetail,
    //                 'prixEnGros' => $request->prixEnGros,
    //                 'quantite' => $request->quantite
    //             ]);

    //             foreach ($request->caracteristiques as $variable) {
    //                 CaracteristiqueProduct::create([
    //                     'caracteristique_id' => $variable['caracteristique_id'],
    //                     'product_id' => $product->id,
    //                     'unite_id' => $request->unite_id,
    //                     'description' => $variable['description'],
    //                     'valeur' => $variable['valeur']
    //                 ]);
    //             }

    //             $response = $product;
    //         } catch (\Exception $e) {
    //             $response = ['error' => $e->getMessage()];
    //         }
    //     });
    //     if (isset($response['error'])) {
    //         return $this->error(500, $response['error']);
    //     } else {

    //         return $this->success(200, "", $response);
    //     }
    // }
    public function store(ProductRequest $request)
    {

        $response = null;
        DB::beginTransaction();
        try {
            $existingProduct = Product::where('libelle', $request->libelle)
                ->where('code', $request->code)
                ->first();
            if (!$existingProduct) {
                $libelle = ucfirst(strtolower($request->libelle));
                $reduction = $request->reduction ?: 0;
                $product = Product::create([
                    'libelle' => $libelle,
                    'code' => $request->code,
                    'reduction' => $reduction,
                    'categorie_id' => $request->categorie_id,
                    'marque_id' => $request->marque_id,
                    'photo' => $request->image,
                ]);
            } else {
                $product = $existingProduct;
            }
            $existingSuccursaleProduct = ProductSuccursale::where('succursale_id', $request->succursale_id)
                ->where('product_id', $product->id)
                ->first();

            if ($existingSuccursaleProduct) {
                ProductSuccursale::where('succursale_id', $request->succursale_id)
                    ->where('product_id', $product->id)
                    ->update([
                        'quantite' => DB::raw('quantite + ' . $request->quantite)
                    ]);
            } else {
                ProductSuccursale::create([
                    'succursale_id' => $request->succursale_id,
                    'product_id' => $product->id,
                    'prixDetail' => $request->prixDetail,
                    'prixEnGros' => $request->prixEnGros,
                    'quantite' => $request->quantite,
                ]);
            }
            foreach ($request->caracteristiques as $variable) {
                CaracteristiqueProduct::create([
                    'caracteristique_id' => $variable['caracteristique_id'],
                    'product_id' => $product->id,
                    'unite_id' => $request->unite_id,
                    'description' => $request->description,
                    'valeur' => $variable['valeur'],
                ]);
            }
            DB::commit();
            $response = $product;
        } catch (\Exception $e) {
            DB::rollback();
            $response = ['error' => $e->getMessage()];
        }


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

    public function search(Request $request)
    {
        $votreId = 1;
        $produit = Product::where("code", $request->code)->first();
        if (!$produit) {
            return $this->error(500, 'produit introuvable');
        }
        $product = Product::with('caracteristiques')->where('code', $request->code)
            ->whereHas('productSuccursales', function ($query) use ($votreId) {
                $query->where('succursale_id', $votreId);
            })->get();
        $succursale = ProductSuccursale::where('succursale_id', $votreId)
            ->where('product_id', $product[0]->id)
            ->first();
        $product->each(function ($product) use ($succursale) {
            $product->details = $succursale;
        });
        if ($product[0]->details->quantite > 0) {
            $data = [
                "product" =>  new ProductResource($product[0]),
                "succursales" =>  []
            ];
            return $this->success(200, '', $data);
        }

        $succursales = ProductSuccursale::where('product_id', $product[0]->id)->orderby('quantite')->get();
        $amis = Ami::where('succursale1_id', $votreId)->pluck('succursale2_id');
        $babsBieber = array_values(array_filter([...$succursales], function ($element) use ($amis) {
            return in_array($element->succursale_id, [...$amis]);
        }));
        $data = [
            "product" =>  new ProductResource($product[0]),
            "succursales" =>  ProductSuccursaleResource::collection($babsBieber)
        ];
        return $this->success(200, '', $data);
    }










    public function search2(Request $request)
    {
        $produit = Product::where("libelle", $request->libelle)->first();
        if (!$produit) {
            return $this->error(500, 'produit introuvable');
        }
        $product = Product::with('caracteristiques')->where('libelle', $request->libelle)->get();
        return $this->success(200, '', new ProductResource21($product[0]));
    }
}
