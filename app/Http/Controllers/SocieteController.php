<?php

namespace App\Http\Controllers;

use App\Http\Requests\SocieteFormRequest;
use App\Societe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DateTime;
use MercurySeries\Flashy\Flashy;

class SocieteController extends Controller
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

        $demandes = nonConsult();

        $societes = Societe::all();

        return view('societes.liste', compact('demandes', 'societes'));
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

        return view('societes.create', compact('demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SocieteFormRequest $request)
    {
        $date = new DateTime();

        $verification = Societe::where('nomSociete', $request->input('societe'))->first();

       /* $pourcent = Societe::sum('pourcentage');

        $pourcent = $pourcent + $request->input('pourcentage');

        if ($pourcent > 100){
            Flashy::error('la somme des pourcentages ne doit pas depasser 100');
            return back();
        }*/
        //dd($verification);
        if ($verification){
            Session::flash('societeExiste');
            return back();
        }
        $societe = new Societe();
        $societe->nomSociete = $request->input('societe');
        $societe->slug = $request->input('societe').$date->format('Ymd');
        $societe->save();

        Flashy::success('Societe ajoutee avc succes');

        return redirect()->route('societe.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Societe  $societe
     * @return \Illuminate\Http\Response
     */
    public function show(Societe $societe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Societe  $societe
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $societe = Societe::whereSlug($slug)->first();

        return view('societes.edit', compact('societe', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Societe  $societe
     * @return \Illuminate\Http\Response
     */
    public function update(SocieteFormRequest $request, $slug)
    {
        //Avant tout d'abord on verifie si la societe n'existe pas dans la table avant de valider les modifications
        //S'il existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $verification = Societe::where('nomSociete',$request->input('societe'))->first();
        if ($verification){
            //On verifie si la ligne trouvee est differente de celle qu'on est entrain de modifier
            //Si c'est le cas on empeche la modification tout en ramenant un message d'erreur
            //Si c'est la meme ligne on valide les modifications
            if ($verification->slug != $slug){
                Session::flash('societeExiste');
                return back();
            }
        }

        $societe = Societe::whereSlug($slug)->first();
        $societe->nomSociete = $request->input('societe');
        $societe->save();

        Flashy::success('Societe modifiee avec succes');

        return redirect()->route('societe.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Societe  $societe
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $societe = Societe::whereSlug($slug)->first();
        $societe->delete();

        Flashy::success('Societe supprimee avec succes');

        return redirect()->route('societe.index');

    }
}
