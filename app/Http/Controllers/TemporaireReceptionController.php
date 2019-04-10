<?php

namespace App\Http\Controllers;

use App\Article;
use App\Stock;
use App\TemporaireReception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TemporaireReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $articles=Article::all();
        return view('detailReceptions.ajoutLigneReception',compact('articles', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //verification dans la table article si la quantite maximun n'a pas ete atteinte
        $quantiteStock = 0; //la quantite en stock
        if(get_article_unique_in_stock($request->input('article'))==true){
            $stock = Stock::findOrFail(session('stockAmodifier'));
            $quantiteStock = $stock->quaniteStock;
        }

        /*quantite disponible plus la quantite a ajouter*/
        $quantiteDisponible = $quantiteStock + $request->input('quantite');

        //quantite maximale a ne pas depasser se treouvant dans articles
        $quantiteMaximum = Article::findOrFail($request->input('article'))->quantiteMaximum;

        //on virifie si la quantite maximum n'est pas atteinte
        if($quantiteDisponible > $quantiteMaximum){
            Session::flash('quantiteAtteinte');
            return back();
        }

        $lignes=new TemporaireReception();
        $lignes->articles=$request->input('article');
        $lignes->quantite=$request->input('quantite');
        $lignes->prixUnitaire=$request->input('prixUnitaire');
        $lignes->save();
        return redirect()->route('detailReception.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TemporaireReception  $temporaireReception
     * @return \Illuminate\Http\Response
     */
    public function show(TemporaireReception $temporaireReception)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TemporaireReception  $temporaireReception
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $articles=Article::all();
        $temporaires=TemporaireReception::findOrFail($id);
        return view('detailReceptions.modifLigneReception',compact('articles','temporaires', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TemporaireReception  $temporaireReception
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //verification dans la table article si la quantite maximun n'a pas ete atteinte
        $quantiteStock = 0; //la quantite en stock
        if(get_article_unique_in_stock($request->input('article'))==true){
            $quantite = Stock::findOrFail(session('stockAmodifier'));
            $quantiteStock = $quantite->quaniteStock;

        }
        /*quantite disponible plus la quantite a ajouter*/
        $quantiteDisponible = $quantiteStock + $request->input('quantite');

        //quantite maximale a ne pas depasser se treouvant dans articles
        $quantiteMaximum = Article::findOrFail($request->input('article'))->quantiteMaximum;

        //on virifie si la quantite maximum n'est pas atteinte
        if($quantiteDisponible > $quantiteMaximum){
            Session::flash('quantiteAtteinte');
            return back();
        }

        $temporaires=TemporaireReception::findOrFail($id);
        $temporaires->articles=$request->input('article');
        $temporaires->quantite=$request->input('quantite');
        $temporaires->prixUnitaire=$request->input('prixUnitaire');
        $temporaires->save();
        return redirect()->route('ligneDeCommande.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TemporaireReception  $temporaireReception
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $temporaires=TemporaireReception::findOrFail($id);
        $temporaires->delete();
        return redirect()->route('detailReception.create');
    }
}
