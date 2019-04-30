<?php

namespace App\Http\Controllers;

use App\Article;
use App\TemporaireCotation;
use App\TemporaireDemande;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;

class TemporaireCotationController extends Controller
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
        return view('detailCotations.create',compact('articles', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('quantite')){
            $lignes = new TemporaireCotation();
            $lignes->articles = $request->input('article');
            $lignes->quantite = $request->input('quantite');
            $lignes->save();
            return redirect()->route('detailCotation.create',compact('lignes'));
        }
        Flashy::error('La quantite est recquise');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TemporaireCotation  $temporaireCotation
     * @return \Illuminate\Http\Response
     */
    public function show(TemporaireCotation $temporaireCotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TemporaireCotation  $temporaireCotation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TemporaireCotation  $temporaireCotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TemporaireCotation $temporaireCotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TemporaireCotation  $temporaireCotation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $temporaireCotation = TemporaireCotation::findOrFail($id);
        $temporaireCotation->delete();
        return redirect()->route('detailCotation.create');
    }
}
