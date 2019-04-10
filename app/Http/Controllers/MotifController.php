<?php

namespace App\Http\Controllers;

use App\Http\Requests\motifFormResquest;
use App\Motif;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Session;
use MercurySeries\Flashy\Flashy;

class MotifController extends Controller
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

        $motifs=Motif::all();
        return view('motifs.list',compact('motifs', 'demandes'));
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

        return view('motifs.create', compact('demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(motifFormResquest $request)
    {
        //Avant tout d'abord on verifie si la famille d'article n'existe pas dans la table avant d'inserer
        //Si elle existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $motifs = Motif::where('motif',$request->input('motif'))->first();
        if ($motifs){
            Session::flash('warning');
            return back();
        }

        $date=new DateTime();
        $motifs=new Motif();
        $motifs->motif=$request->input('motif');
        $motifs->slug=$request->input('motif').$date->format('YmdHis');
        $motifs->save();
        Flashy::success('Motif enregistrer avec succes');
        return redirect()->route('motif.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Motif  $motif
     * @return \Illuminate\Http\Response
     */
    public function show(Motif $motif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Motif  $motif
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $motif = Motif::whereSlug($slug)->first();
        //dd($slug);
        return view('motifs.edit',compact('motif', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Motif  $motif
     * @return \Illuminate\Http\Response
     */
    public function update(motifFormResquest $request, $slug)
    {

        //Avant tout d'abord on verifie si la categorie du fournisseur n'existe pas dans la table avant de valider les modifications
        //S'il existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $motifs = Motif::where('motif',$request->input('motif'))->first();
        if ($motifs){
            //On verifie si la ligne trouvee est differente de celle qu'on est entrain de modifier
            //Si c'est le cas on empeche la modification tout en ramenant un message d'erreur
            //Si c'est la meme ligne on valide les modifications
            if ($motifs->slug != $slug){
                Session::flash('warning');
                return back();
            }
        }

        $motif = Motif::whereSlug($slug)->first();
        $motif->motif=$request->input('motif');
        $motif->save();

        Flashy::success('Motif modifier avec succes');
        return redirect()->route('motif.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Motif  $motif
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $motif = Motif::whereSlug($slug)->first();
        $motif->delete();

        Flashy::success('Motif supprime avec succes');
        return redirect()->route('motif.index');
    }
}
