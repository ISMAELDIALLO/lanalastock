<?php

namespace App\Http\Controllers;

use App\CategorieFournisseur;
use App\Fournisseur;
use Illuminate\Http\Request;
use \DateTime;
use Illuminate\Support\Facades\DB;
use MercurySeries\Flashy\Flashy;

class FournisseurController extends Controller
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

        $fournisseurs=DB::table('categorie_fournisseurs')
            ->join('fournisseurs','categorie_fournisseurs.id','=','fournisseurs.categorie_fournisseurs_id')
            ->select('categorie_fournisseurs.libelleCategorieFournisseur','fournisseurs.*')
            ->get();
        return view('fournisseurs.list',compact('fournisseurs', 'demandes'));
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

        $categories=CategorieFournisseur::all();
        return view('fournisseurs.create',compact('categories', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fours=Fournisseur::select(DB::raw("CONCAT('FR0', MAX(CAST(RIGHT(codeFournisseur,LENGTH(codeFournisseur)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $fr="FR01";
        foreach ($fours as $four){
            if ($four->code){
                $fr=$four->code;
            }
        }
        $date=new DateTime();
        $fournisseurs=new Fournisseur();
        $fournisseurs->categorie_fournisseurs_id=$request->input('categorie');
        $fournisseurs->codeFournisseur=$fr;
        $fournisseurs->nomSociete=$request->input('nomSociete');
        $fournisseurs->nomDuContact=$request->input('nomContact');
        $fournisseurs->prenomDuContact=$request->input('prenomContact');
        $fournisseurs->telephoneDuContact=$request->input('telephone');
        $fournisseurs->observation=$request->input('observation');
        $fournisseurs->slug=$request->input('telephone').$date->format('YmdHis');
        $fournisseurs->save();
        Flashy::success('Fournisseur enregistrer avec succes');
        return redirect()->route('fournisseur.index');

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

        $categories=CategorieFournisseur::all();
        $fournisseurs=Fournisseur::where('slug', $slug)->first();
        return view('fournisseurs.edit',compact('categories','fournisseurs', 'demandes'));
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
        // $articles = Article::where('slug', $slug)->first();
        $fournisseurs=Fournisseur::where('slug',$slug)->first();
        $fournisseurs->categorie_fournisseurs_id=$request->input('categorie');
        $fournisseurs->nomSociete=$request->input('nomSociete');
        $fournisseurs->nomDuContact=$request->input('nomContact');
        $fournisseurs->prenomDuContact=$request->input('prenomContact');
        $fournisseurs->telephoneDuContact=$request->input('telephone');
        $fournisseurs->observation=$request->input('observation');
        $fournisseurs->save();
        Flashy::success('Fournisseur modifier avec succes');
        return redirect()->route('fournisseur.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $fournisseurs=Fournisseur::where('slug', $slug)->first();
        $fournisseurs->delete();
        Flashy::success('Fournisseur supprimee avec succes');
        return redirect()->route('fournisseur.index');
    }
}
