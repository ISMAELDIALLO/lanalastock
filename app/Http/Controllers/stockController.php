<?php

namespace App\Http\Controllers;

use App\Article;
use App\DetailSortieStock;
use App\Motif;
use App\SortieStock;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use DateTime;
use MercurySeries\Flashy\Flashy;

class stockController extends Controller
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

        //recuperation de la quantite minimum

        $stocks = DB::table('articles')
            ->join('stocks', 'articles.id', '=', 'stocks.articles_id')
            ->select('stocks.*', 'articles.libelleArticle', 'articles.referenceArticle', 'articles.quantiteMinimum','articles.quantiteMaximum')
            ->get();

        return view('stocks.list', compact('stocks', 'demandes'));
    }

    public function aApprovisionner(){
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        //recuperation de la quantite minimum

        $stocks = DB::table('articles')
            ->join('stocks', 'articles.id', '=', 'stocks.articles_id')
//            ->where('stocks.quaniteStock', '<=', 'articles.quantiteMinimum')
            ->select('stocks.*', 'articles.libelleArticle', 'articles.referenceArticle', 'articles.quantiteMinimum','articles.quantiteMaximum')
            ->get();

        return view('stocks.aApprovisionner', compact('stocks', 'demandes'));
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
                    ->join('stocks','articles.id','=','stocks.articles_id')
                    ->select('articles.*')
                    ->get();

        $motifs = Motif::all();

        //Retour de la vue qui permet de faire une sortie exceptionnelle

        return view('stocks.sortieExceptionnelle',compact('demandes', 'articles', 'motifs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Recuperation de la quantite dans le stock
        $quanitestock = Stock::where('articles_id',$request->input('article'))->first();

        $quanitestock = $quanitestock->quaniteStock;
        $date = new DateTime();
        //on recupere la quantite qui restera apres la modification
        $nouvelleQuantite = $quanitestock - $request->input('quantite');

        //on verifie si la quantite a dimunier n'est pas superieure a celle disponible

        if($nouvelleQuantite < 0){
            //Si c'est le cas on renvoi un message d'erreur
            Session::flash('warning');
            return back();
        }

        //dans le cas contraire on effectue la modification en dimuniant la quantite

        $stock = Stock::where('articles_id',$request->input('article'))->first();
        $stock->quaniteStock = $nouvelleQuantite;
        $stock->save();


        //insertion de la sortie dans la table sortie_stock
        $sors=SortieStock::select(DB::raw("CONCAT('S00', MAX(CAST(RIGHT(codeSortie,LENGTH(codeSortie)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $sr="S001";
        foreach ($sors as $sor){
            if ($sor->code){
                $sr=$sor->code;
            }
        }

        //insertion dans la table sortie_stocks
        $sortie = new SortieStock();
        $sortie->codeSortie = $sr;
        $sortie->dateSortie = $date->format('Y-m-d');
        $sortie->users_id = auth()->user()->id;
        $sortie->save();
        //on recupere l'id de la sortie pour l'inserer dans detail_sortie_stocks
        $idSortie = SortieStock::max('id');


        //Insertion dans dans detail_sortie_stocks
        $detail_sortie_stoks = new DetailSortieStock();
        $detail_sortie_stoks->articles_id = $stock->articles_id;
        $detail_sortie_stoks->quantiteSortante = $request->input('quantite');
        $detail_sortie_stoks->motif = $request->input('motif');
        $detail_sortie_stoks->sortie_stocks_id = $idSortie;
        $detail_sortie_stoks->save();

        Flashy::success('Sortie stock effectue avec succes');
        return redirect()->route('stock.index');
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
    public function edit($slug)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        //on recupere le stock a modifier
        $stock = Stock::whereSlug($slug)->first();
        $motifs=Motif::all();
        //on recupere la quantite en stock pour cet article avant la modification
        Session::put('quantiteStock', $stock->quaniteStock);


        return view('stocks.edit', compact('stock','motifs', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {

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
