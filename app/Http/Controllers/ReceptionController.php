<?php

namespace App\Http\Controllers;

use App\Fournisseur;
use App\Reception;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceptionController extends Controller
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

        $receptions=DB::table('fournisseurs')
            ->join('receptions','fournisseurs.id','=','receptions.fournisseurs_id')
            ->select('fournisseurs.nomSociete','fournisseurs.nomDuContact','fournisseurs.prenomDuContact','fournisseurs.telephoneDuContact','receptions.*')
            ->get();
        return view('receptions.liste',compact('receptions', 'demandes'));
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

        $fournisseurs=Fournisseur::all();
        return view('receptions.create',compact('fournisseurs', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $receptions=DB::table('receptions')
            ->join('detail_receptions','receptions.id','=','detail_receptions.receptions_id')
            ->join('articles','articles.id','detail_receptions.articles_id')
            ->where('detail_receptions.receptions_id', '=', $id)
            ->select('articles.referenceArticle','articles.libelleArticle','receptions.codeReception','dateReception','detail_receptions.*')
            ->orderBy('receptions.id', 'desc')
            ->get();

        $codeReception = "";
        foreach ($receptions as $rec){
            $codeReception = $rec->codeReception;
        }

        return view('receptions.details',compact('receptions', 'demandes', 'codeReception'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {

        $receptions=DB::table('articles')
            ->join('detail_receptions','detail_receptions.articles_id','=','articles.id')
            ->join('receptions','receptions.id','=','detail_receptions.receptions_id')
            ->join('fournisseurs','fournisseurs.id','=','receptions.fournisseurs_id')
            ->select('detail_receptions.quantite','detail_receptions.prixUnitaire','articles.libelleArticle','fournisseurs.nomSociete','receptions.*')
            ->where('receptions.slug','=',$slug)
            ->get();
        $codeReception="";
        $dateReception="";
        $fournisseur="";
        $montant=0;
        foreach ($receptions as $reception){
            $codeReception=$reception->codeReception;
            $dateReception=$reception->dateReception;
            $fournisseur=$reception->nomSociete;
            $montant+=($reception->quantite*$reception->prixUnitaire);
        }
        $pdf = PDF::loadView('receptions.print', compact('receptions','codeReception','dateReception','fournisseur','montant'))->setPaper('a4', 'portrait');
        $fileName = $codeReception;
        return $pdf->stream($fileName . '.pdf');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reception $reception)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reception $reception)
    {
        //
    }
}
