<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\temporaireFormRequest;
use App\Stock;
use App\tableTemporaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DateTime;
use MercurySeries\Flashy\Flashy;

class tableTemporaireController extends Controller
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
        return view('ligneDeCommandes.ajoutLigne',compact('articles', 'demandes'));
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

        if (!$request->input('quantite')){
            Flashy::error('La quantite est requise');
            return back();
        }else if (!$request->input('prixUnitaire')){
            Flashy::error('Le prix unitaire est obligatoire');
            return back();
        }
        $lignes=new tableTemporaire();
        $lignes->articles = $request->input('article');
        $lignes->quantite = $request->input('quantite');
        $lignes->prixUnitaire = $request->input('prixUnitaire');
        $lignes->users_id = auth()->user()->id;
        $lignes->save();
        return redirect()->route('commande.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $articles=Article::all();
        $temporaires=tableTemporaire::findOrFail($id);
        return view('LigneDeCommandes.modifLigne',compact('articles','temporaires', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(temporaireFormRequest $request, $id)
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

        $temporaires=tableTemporaire::findOrFail($id);
        $temporaires->articles=$request->input('article');
        $temporaires->quantite=$request->input('quantite');
        $temporaires->save();
        return redirect()->route('ligneDeCommande.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $temporaires=tableTemporaire::findOrFail($id);
        $temporaires->delete();
        return redirect()->route('commande.create');
    }
}
