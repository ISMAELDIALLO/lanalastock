<?php

namespace App\Http\Controllers;

use App\CategorieFournisseur;
use App\Http\Requests\categorieFournisseurFormResquest;
use Illuminate\Http\Request;
use \DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use MercurySeries\Flashy\Flashy;

class CategorieFournisseurController extends Controller
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

        $categories = CategorieFournisseur::all();

        return view('categorieFournisseurs.list', compact('categories', 'demandes'));
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

        $demandes= nonConsult();

        return view('categorieFournisseurs.create', compact('demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(categorieFournisseurFormResquest $request)
    {
        //Avant tout d'abord on verifie si la famille d'article n'existe pas dans la table avant d'inserer
        //Si elle existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $categorieFournisseur = CategorieFournisseur::where('libelleCategorieFournisseur',$request->input('categorie'))->first();
        if ($categorieFournisseur){
            Session::flash('warning');
            return back();
        }

        //geneation automatique du categorie fournisseur
        $cats=CategorieFournisseur::select(DB::raw("CONCAT('CF0', MAX(CAST(RIGHT(codeCategorieFournisseur,LENGTH(codeCategorieFournisseur)-3) AS UNSIGNED))+1) AS categorie"))
            ->get();
        $cf="CF01";
        foreach ($cats as $cat){
            if ($cat->categorie){
                $cf=$cat->categorie;
            }
        }
        $date = new DateTime();
        $categorie = new CategorieFournisseur();
        $categorie->codeCategorieFournisseur =$cf;
        $categorie->libelleCategorieFournisseur = $request->input('categorie');
        $categorie->slug = $request->input('categorie').$date->format('YmdHis');
        $categorie->save();
        Flashy::success('Categorie fournisseur enregistrer avec succes');
        return redirect()->route('categorieFournisseur.index');
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

        $demandes= nonConsult();

        $categories = CategorieFournisseur::where('slug', $slug)->first();

        return view('categorieFournisseurs.edit',compact('categories', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(categorieFournisseurFormResquest $request, $slug)
    {
        //Avant tout d'abord on verifie si la categorie du fournisseur n'existe pas dans la table avant de valider les modifications
        //S'il existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $categorieFournisseur = CategorieFournisseur::where('libelleCategorieFournisseur',$request->input('categorie'))->first();
        if ($categorieFournisseur){
            //On verifie si la ligne trouvee est differente de celle qu'on est entrain de modifier
            //Si c'est le cas on empeche la modification tout en ramenant un message d'erreur
            //Si c'est la meme ligne on valide les modifications
            if ($categorieFournisseur->slug != $slug){
                Session::flash('warning');
                return back();
            }
        }
        $categories=CategorieFournisseur::where('slug',$slug)->first();
        $categories->libelleCategorieFournisseur=$request->input('categorie');
        $categories->save();
        Flashy::success('Categorie fournisseur modifier avec succes');
        return redirect()->route('categorieFournisseur.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $categories=CategorieFournisseur::where('slug', $slug)->first();
        $categories->delete();
        Flashy::success('categorie fournisseur supprimee avec succes');
        return redirect()->route('categorieFournisseur.index',compact('categories'));
    }
}
