<?php

namespace App\Http\Controllers;

use App\CategorieFournisseur;
use App\SuperCategorieArticle;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use MercurySeries\Flashy\Flashy;

class SuperCategorieArticleController extends Controller
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

        $categories = SuperCategorieArticle::all();

        return view('superCategorie.liste',compact('demandes','categories'));
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

        return view('superCategorie.ajout',compact('demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Avant tout d'abord on verifie si la categorie du fournisseur n'existe pas dans la table avant d'inserer
        //Si elle existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $superCategorieArticle = SuperCategorieArticle::where('superCategorie',$request->input('superCategorie'))->first();
        if ($superCategorieArticle){
            Session::flash('warning');
            return back();
        }

        //geneation automatique du code super categorie
        $scas=SuperCategorieArticle::select(DB::raw("CONCAT('SCA0', MAX(CAST(RIGHT(codeSuperCategorie,LENGTH(codeSuperCategorie)-4) AS UNSIGNED))+1) AS code"))
            ->get();
        $sp="SCA01";
        foreach ($scas as $sca){
            if ($sca->code){
                $sp=$sca->code;
            }
        }
        $date = new DateTime();
        $superCategorieArticles = new SuperCategorieArticle();
        $superCategorieArticles->codeSuperCategorie = $sp;
        $superCategorieArticles->superCategorie = $request->input('superCategorie');
        $superCategorieArticles->slug = $request->input('superCategorie').$date->format('YmdHis');
        $superCategorieArticles->save();
        Flashy::success('Categorie fournisseur enregistrer avec succes');
        return redirect()->route('superCategorie.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SuperCategorieArticle  $superCategorieArticle
     * @return \Illuminate\Http\Response
     */
    public function show(SuperCategorieArticle $superCategorieArticle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SuperCategorieArticle  $superCategorieArticle
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes= nonConsult();
        $superCategories = SuperCategorieArticle::where('slug', $slug)->first();

        return view('superCategorie.modif',compact('superCategories', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SuperCategorieArticle  $superCategorieArticle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //Avant tout d'abord on verifie si ce Super Categorie Article n'existe pas dans la table avant de valider les modifications
        //S'il existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $superCategorie = SuperCategorieArticle::where('superCategorie',$request->input('superCategorie'))->first();
        if ($superCategorie){
            //On verifie si la ligne trouvee est differente de celle qu'on est entrain de modifier
            //Si c'est le cas on empeche la modification tout en ramenant un message d'erreur
            //Si c'est la meme ligne on valide les modifications
            if ($superCategorie->slug != $slug){
                Session::flash('warning');
                return back();
            }
        }
        $SuperCategories = SuperCategorieArticle::where('slug',$slug)->first();
        $SuperCategories->superCategorie=$request->input('superCategorie');
        $SuperCategories->save();
        Flashy::success('Super Categorie modifier avec succes');
        return redirect()->route('superCategorie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SuperCategorieArticle  $superCategorieArticle
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $SuperCategories = SuperCategorieArticle::where('slug', $slug)->first();
        $SuperCategories->delete();
        Flashy::success('Super Categorie supprimee avec succes');
        return redirect()->route('superCategorie.index');
    }
}
