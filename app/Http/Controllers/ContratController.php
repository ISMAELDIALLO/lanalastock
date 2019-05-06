<?php

namespace App\Http\Controllers;

use App\Article;
use App\HistoriqueArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

class ContratController extends Controller
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
        $articles=DB::table('super_categorie_articles')
            ->join('famille_articles', 'super_categorie_articles.id', '=', 'famille_articles.super_categories_id')
            ->join('articles','famille_articles.id','=','articles.famille_articles_id')
            ->where('articles.type', '=', 2)
            ->select('famille_articles.libelleFamilleArticle','articles.*')
            ->get();
        return view('articles.listeContrat',compact('articles', 'demandes'));
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

        $familles = DB::table('super_categorie_articles')
            ->join('famille_articles', 'super_categorie_articles.id', '=', 'famille_articles.super_categories_id')
            ->select('super_categorie_articles.superCategorie', 'famille_articles.*')
            ->get();

        return view('articles.ajoutContrat',compact('demandes','familles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $date = new DateTime();
        $contrat = new Article();
        $contrat->famille_articles_id = $request->input('famille');
        $contrat->type = 2;
        if ($request->input('libelleContrat')){
            $contrat->libelleArticle = $request->input('libelleContrat');
        }
        if ($request->input('periodicitePayement')){
            $contrat->periodicitePayement=$request->input('periodicitePayement');
        }
        if ($request->input('dateDebutContrat')){
            $contrat->dateDebutContrat = $request->input('dateDebutContrat');
        }
        if ($request->input('dateFinContrat')){
            $contrat->dateFinContrat = $request->input('dateFinContrat');
        }
        if ($request->input('dernierPrix')){
            $contrat->dernierPrix = $request->input('dernierPrix');
        }
        $contrat->slug=$request->input('libelle').$date->format('YmdHis');
        $contrat->save();

        //on insere dans la table historique
        $historique = new HistoriqueArticle();
        if ($request->input('libelle')){
            $historique->article = $request->input('libelle');
        }
        if ($request->input('dateDebutContrat')){
            $historique->dateDebutContrat = $request->input('dateDebutContrat');
        }
        if ($request->input('dateFinContrat')){
            $historique->dateFinContrat = $request->input('dateFinContrat');
        }
        if ($request->input('dernierPrix')){
            $historique->prixUnitaire = $request->input('dernierPrix');
        }
        $historique->save();

        return redirect()->route('contrat.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
