<?php

namespace App\Http\Controllers;

use App\Compte;
use App\ComptePrincipal;
use App\Societe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use MercurySeries\Flashy\Flashy;

class CompteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page
        $demandes= nonConsult();

        $comptes = Compte::all();
        //dd(money_format('%i', 145201));

        return view('comptes.list',compact('demandes','comptes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page
        $demandes = nonConsult();

        $societes = Societe::all();
        return view('comptes.ajout', compact('demandes', 'societes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $comptes = Compte::where('compte',$request->input('compte'))->first();
        if ($comptes){
            Session::flash('warning');
            return back();
        }
        $comptes = new Compte();
        $comptes->societes_id = $request->input('societe');
        $comptes->compte = $request->input('compte');
        $comptes->save();

        return redirect()->route('compte.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function show(Compte $compte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page
        $demandes = nonConsult();

        $comptes = Compte::findOrFail($id);
        $societes = Societe::all();
        return view('comptes.modif', compact('comptes', 'societes', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       //Permet d'aller chercher le nom du compte que l'utilisateur à saisie pour le trouver dans la base
        $nomCompte = Compte::where('compte',$request->input('compte'))->first();
        if ($nomCompte){
            //On verifie  si la ligne qu'il a choisie  est differente de celle qui est entrain est entrain d'être modifier
            if ($nomCompte->id != $id){
                Session::flash('warning');
                return back();
            }
        }
        $comptes = Compte::findOrFail($id);
        $comptes->societes_id = $request->input('societe');
        $comptes->compte = $request->input('compte');
        $comptes->save();

        return redirect()->route('compte.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Compte  $compte
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comptes = Compte::findOrFail($id);

        $comptes->delete();

        Flashy::error('Suppression effectuez avec succes');
        return redirect()->route('compte.index');
    }
}
