<?php

namespace App\Http\Controllers;

use App\Article;
use App\Cotation;
use App\Demande;
use App\DetailCotation;
use App\DetailDemande;
use App\TemporaireCotation;
use App\TemporaireDemande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MercurySeries\Flashy\Flashy;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use DateTime;

class DetailCotationController extends Controller
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

        $dateDemande = new DateTime();
        $dateDemande = $dateDemande->format('Y-m-d');
        $lignes=DB::table('articles')
            ->join('temporaire_cotations','articles.id','=','temporaire_cotations.articles')
            ->select('articles.libelleArticle','temporaire_cotations.*')
            ->get();
        $articles = Article::all();
        return view('detailCotations.create',compact('demandes','dateDemande','articles','lignes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Enregistrement de la demande
        $cots = Cotation::select(DB::raw("CONCAT('CT0', MAX(CAST(RIGHT(codeCotation,LENGTH(codeCotation)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $ct="CT01";
        foreach ($cots as $cot){
            if ($cot->code){
                $ct=$cot->code;
            }
        }
        $dateCotation = new DateTime();
        $dateCotation = $dateCotation->format('Y-m-d');
        $cotations = new Cotation();
        $cotations->codeCotation = $ct;
        $cotations->dateCotation = $dateCotation;
        $cotations->users_id = auth()->user()->id;
        $cotations->save();

        //Selection de l'identifiant de la demande
        $idCotations = Cotation::max('id');
        /*Insertion dans detail cotation, tanque ya d'enregistrement dans la table temporaire Demande on insert dans la table
         detail cotation et à chque fois on un nouvel objet et apres insertion on supprime les données dans la table temporaire
        */
        $temporaireCotations = TemporaireCotation::all();

        foreach ($temporaireCotations as $temporaireCotation){
            $detailCotation =new DetailCotation();
            $detailCotation->cotations_id = $idCotations;
            $detailCotation->articles_id = $temporaireCotation->articles;
            $detailCotation->quantite = $temporaireCotation->quantite;
            $detailCotation->save();
        }

        TemporaireCotation::truncate();

        Flashy::success('Cotation enregistrer avec succes');
        return redirect()->route('detailCotation.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailCotation  $detailCotation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $cots = DB::table('cotations')
            ->join( 'detail_cotations','detail_cotations.cotations_id','=','cotations.id')
            ->join('articles','detail_cotations.articles_id','=','articles.id')
            ->where('detail_cotations.cotations_id','=',$id)
            ->select('articles.libelleArticle','cotations.codeCotation','detail_cotations.*')
            ->get();
        $codeCotation = "";
        foreach ($cots as $cot){
            $codeCotation = $cot->codeCotation;
        }
        return view('detailCotations.details',compact('cots','codeCotation','demandes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailCotation  $detailCotation
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailCotation $detailCotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailCotation  $detailCotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailCotation $detailCotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailCotation  $detailCotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailCotation $detailCotation)
    {
        //
    }
}
