<?php

namespace App\Http\Controllers;

use App\Cotation;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CotationController extends Controller
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

        $listCotations = DB::table('users')
            ->join('cotations', 'users.id', '=', 'cotations.users_id')
            ->select(
                'users.nom', 'users.prenom', 'cotations.*'
            )
            ->orderBy('cotations.id', 'desc')
            ->get();

        return view('detailCotations.list', compact('demandes', 'listCotations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Cotation  $cotation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cotations =DB::table('articles')
            ->join('detail_cotations','detail_cotations.articles_id','=','articles.id')
            ->join('cotations','cotations.id','=','detail_cotations.cotations_id')
            ->select('detail_cotations.quantite','articles.libelleArticle','cotations.*')
            ->where('cotations.id','=',$id)
            ->get();
        $codeCotation="";
        $dateCotation="";
        foreach ($cotations as $cotation){
            $codeCotation = $cotation->codeCotation;
            $dateCotation = $cotation->dateCotation;
        }

        $pdf = PDF::loadView('detailCotations.print', compact('cotations','codeCotation','dateCotation'))->setPaper('a4', 'portrait');
        $fileName = $codeCotation;
        return $pdf->stream($fileName . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cotation  $cotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Cotation $cotation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cotation  $cotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cotation $cotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cotation  $cotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotation $cotation)
    {
        //
    }
}
