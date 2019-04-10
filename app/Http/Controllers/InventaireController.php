<?php

namespace App\Http\Controllers;

use App\Article;
use App\Inventaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InventaireController extends Controller
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

        $inventaires = DB::table('users')
            ->join('inventaires', 'users.id', '=', 'inventaires.users_id')
            ->select('users.nom', 'users.prenom', 'users.email', 'inventaires.*')
            ->get();

        return view('Inventaires.list', compact('demandes', 'inventaires'));
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
     * @param  \App\Inventaire  $inventaire
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $detailInventaires = DB::table('users')
            ->join('inventaires', 'users.id', '=', 'inventaires.users_id')
            ->join('detail_inventaires', 'inventaires.id', '=', 'detail_inventaires.inventaires_id')
            ->join('articles', 'articles.id', '=', 'detail_inventaires.articles_id')
            ->where('detail_inventaires.inventaires_id', '=', $id)
            ->select(
                'articles.libelleArticle', 'inventaires.codeInventaire', 'detail_inventaires.*'
            )
            ->get();

        $codeInventaire = "";

        foreach ($detailInventaires as $det){
            $codeInventaire = $det->codeInventaire;
        }
        return view('Inventaires.listeDetail', compact('demandes', 'detailInventaires', 'codeInventaire'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventaire  $inventaire
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $article = Article::findOrFail($id);

        return view('Inventaires.quantitePhysique', compact('demandes', 'article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventaire  $inventaire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //recuperation de la quantite physique dans une variable de session
        Session::put('quantitePhysique'.$id, $request->input('quantitePhysique'));

        return redirect()->route('detailInventaire.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventaire  $inventaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventaire $inventaire)
    {
        //
    }
}
