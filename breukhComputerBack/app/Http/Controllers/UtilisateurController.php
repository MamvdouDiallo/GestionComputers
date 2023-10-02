<?php

namespace App\Http\Controllers;

use App\Traits\HttpResp;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\FlareClient\Http\Response;
use App\Http\Requests\UtilisateurRequest;
use App\Http\Resources\UtilisateurResource;
use App\Http\Resources\UtilisateurCollection;
use Illuminate\Auth\Access\Response as AccessResponse;
use Illuminate\Support\Facades\Response as FacadesResponse;

use App\Http\Requests\UserRequest;
use App\Models\User;


use Illuminate\Support\Facades\Cookie;



class UtilisateurController extends Controller
{
    use HttpResp;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Utilisateur::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UtilisateurRequest $request)
    {
        $data = $request->except('password');
        $data['password'] = Hash::make($request->input('password'));
        $utilisateur = Utilisateur::create($data);
        return $this->success(new UtilisateurResource($utilisateur));
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
    public function destroy(Utilisateur $utilisateur)
    {

        if ($utilisateur) {
            $utilisateur->delete();
            return $this->success(200, "Supprimé avec succées");
        } else {
            return $this->error(500, "Cet utilisateur n'existe pas");
        }
    }

    // public function search(Request $request)
    // {
    //     $user = Utilisateur::where("login", $request->login)->first();
    //     if (!$user) {
    //         return $this->error(500, 'Utilisateur introuvable');
    //     }
    //     $user = Utilisateur::with('caracteristiques')->where('libelle', $request->libelle)->get();
    //     return $this->success(200, '', $user);
    // }



    public function login(Request $request)
    {

        if (!Auth::attempt($request->only("login", "password"))) {
            return response([
                "message" => "Invalid credentials"
            ],);
        }
        $user = Auth::user();
        $token = $user->createToken("token")->plainTextToken;
        $data = [
            "user" => $user,
            "token" => $token
        ];
        return $this->success(200, "", $data);
    }



    public function logout()
    {
        Auth::logout();
        Cookie::forget("token");
        return response([
            "message" => "success"
        ]);
    }

    // public function logout()
    // {
    //     if (Auth::check()) {
    //         Auth::user()->currentAccessToken()->delete();
    //     }
    //     return $this->success(200, 'You have been logged out');
    // }
}
