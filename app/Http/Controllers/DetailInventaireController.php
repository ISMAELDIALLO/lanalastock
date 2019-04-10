<?php

namespace App\Http\Controllers;

use App\Article;
use App\DetailInventaire;
use App\Inventaire;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Session;
use MercurySeries\Flashy\Flashy;
use PDF;

class DetailInventaireController extends Controller
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

        $detailInventaires = DB::table('users')
            ->join('inventaires', 'users.id', '=', 'inventaires.users_id')
            ->join('detail_inventaires', 'inventaires.id', '=', 'detail_inventaires.inventaires_id')
            ->join('articles', 'articles.id', '=', 'detail_inventaires.articles_id')
            ->select(
                'articles.libelleArticle', 'users.nom', 'users.prenom', 'users.email',
                'inventaires.codeInventaire', 'inventaires.dateInventaire',
                'detail_inventaires.*'
            )
            ->get();
        return view('Inventaires.listeDetail', compact('demandes', 'detailInventaires'));
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

        //selection des informations dans la table stock
        $lignes = DB::table('articles')
            ->join('stocks', 'articles.id', '=', 'stocks.articles_id')
            ->select('articles.libelleArticle', 'stocks.*')
            ->get();

        return view('Inventaires.create', compact('demandes', 'lignes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //on verifie si toutes les quantites physiques
        $sts = Stock::all();
        foreach ($sts as $st){
            if (!session('quantitePhysique' . $st->articles_id)){
                Flashy::error('veillez renseigner toutes les quantites physiques.');
                return back();
            }
        }
        //generation automatique du code de l'inventaire
        $codes=Inventaire::select(DB::raw("CONCAT('IV0', MAX(CAST(RIGHT(codeInventaire,LENGTH(codeInventaire)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $codeInventaire="IV01";
        foreach ($codes as $code){
            if ($code->code){
                $codeInventaire=$code->code;
            }
        }

        //Insertion de l'inventaire
        $inventaire = new Inventaire();
        $inventaire->codeInventaire = $codeInventaire;
        $inventaire->dateInventaire = $request->input('dateInventaire');
        $inventaire->users_id = auth()->user()->id;
        $inventaire->save();

        //on selectionne l'identifiant de l'inventaire qu'on vient d'ajouter qui correspond au max id dans la
        //table inventaire

        $idIventaire = Inventaire::max('id');

        //insertion dans la table detailInventaire
        /*on insere dans detail autant de lilgnes qui existent dans la table stock
         * donc on va parcourir la table stock pour recuperer les articles qui s'y trouvent
         * */
        $stocks = Stock::all();
        $date = new DateTime();
        foreach ($stocks as $stock){
            $detailInventaire = new DetailInventaire();
            $detailInventaire->inventaires_id = $idIventaire;
            $detailInventaire->articles_id = $stock->articles_id;
            $detailInventaire->quantiteTheorique = $stock->quaniteStock;
            $detailInventaire->quantitePhysique = session('quantitePhysique' . $stock->articles_id);
            $detailInventaire->slug = $stock->articles_id . $date->format('Ymd');
            $detailInventaire->save();

            //mise a jour de la table articles pour renseigner les champs dateInventaire et quantiteInventaire
            $article = Article::findOrFail($stock->articles_id);
            $article->dateInventaire = $request->input('dateInventaire');
            $article->quantiteInventaire = session('quantitePhysique' . $stock->articles_id);
            $article->save();

            //on oublie la session apres l'enregistrement
            Session::forget('quantitePhysique' . $stock->articles_id);
        }

        return redirect()->route('inventaire.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailInventaire  $detailInventaire
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $details = DB::table('users')
            ->join('inventaires', 'users.id', '=', 'inventaires.users_id')
            ->join('detail_inventaires', 'inventaires.id', '=', 'detail_inventaires.inventaires_id')
            ->join('articles', 'articles.id', '=', 'detail_inventaires.articles_id')
            ->where('detail_inventaires.inventaires_id', '=', $id)
            ->select(
                'articles.libelleArticle', 'inventaires.codeInventaire', 'inventaires.dateInventaire', 'detail_inventaires.*'
            )
            ->get();

        $codeInventaire = "";
        $dateInventaire = "";

        foreach ($details as $det){
            $codeInventaire = $det->codeInventaire;
            $dateInventaire = $det->dateInventaire;
        }
        $pdf = PDF::loadView('Inventaires.print', compact( 'details', 'codeInventaire', 'dateInventaire'))->setPaper('a4', 'portrait');
        $fileName = $codeInventaire;
        return $pdf->stream($fileName . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailInventaire  $detailInventaire
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailInventaire $detailInventaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailInventaire  $detailInventaire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailInventaire $detailInventaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailInventaire  $detailInventaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailInventaire $detailInventaire)
    {
        //
    }
}
