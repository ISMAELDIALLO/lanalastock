<?php

namespace App\Http\Controllers;

use App\Article;
use App\TemporaireDemande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MercurySeries\Flashy\Flashy;

class TemporaireDemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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


        $articles = DB::table('articles')
            ->join('stocks', 'articles.id', '=', 'stocks.articles_id')
            ->select('articles.*')
            ->get();
        return view('detailDemandes.create',compact('articles', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->input('quantite')){
            Flashy::error('La quantite est requise');
            return back();
        }
        $lignes=new TemporaireDemande();
        $lignes->articles=$request->input('article');
        $lignes->quantiteDemandee=$request->input('quantite');
        $lignes->users = auth()->user()->id;
        $lignes->save();
        return redirect()->route('detailDemande.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TemporaireDemande  $temporaireDemande
     * @return \Illuminate\Http\Response
     */
    public function show(TemporaireDemande $temporaireDemande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TemporaireDemande  $temporaireDemande
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $articles=Article::all();
        $temporaireDemandes=TemporaireDemande::findOrFail($id);
        return view('detailDemandes.editLigneDemande',compact('articles','temporaireDemandes', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TemporaireDemande  $temporaireDemande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $temporaireDemandes=TemporaireDemande::findOrFail($id);
        $temporaireDemandes->articles=$request->input('article');
        $temporaireDemandes->quantiteDemandee=$request->input('quantite');
        $temporaireDemandes->save();
        return redirect()->route('detailDemande.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TemporaireDemande  $temporaireDemande
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $temporaireDemandes=TemporaireDemande::findOrFail($id);
        $temporaireDemandes->delete();
        return redirect()->route('detailDemande.create');
    }
}
