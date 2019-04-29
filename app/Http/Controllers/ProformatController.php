<?php

namespace App\Http\Controllers;

use App\Proformat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ProformatController extends Controller
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

        //Affichage de toutes factures proformats non choisies
        $proformats=DB::table('fournisseurs')
            ->join('proformats','fournisseurs.id','=','proformats.fournisseurs_id')
            ->select('fournisseurs.nomSociete','fournisseurs.nomDuContact','fournisseurs.prenomDuContact','fournisseurs.telephoneDuContact','proformats.*')
            ->where('proformats.etat',0)
            ->get();
        return view('proformats.list',compact('proformats', 'demandes'));
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

        // Affichage de toutes les factures proformats
        $proformats=DB::table('fournisseurs')
            ->join('proformats','fournisseurs.id','=','proformats.fournisseurs_id')
            ->select('fournisseurs.nomSociete','fournisseurs.nomDuContact','fournisseurs.prenomDuContact','fournisseurs.telephoneDuContact','proformats.*')
            ->get();
        return view('proformats.listAllProformat',compact('proformats', 'demandes'));
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
     * @param  \App\Proformat  $proformat
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Telechargement et affichage des fichiers

        $proformats = Proformat::where('codeProformat',$id)->first();

        $path = public_path().'/storage/'.$proformats->image;

        return response()->file($path);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proformat  $proformat
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
       //Aucune importance l'impression est enlever dans proformat maintenant c'est l'image qui est directement chargé

        /* $proformats =DB::table('articles')
            ->join('detailProformats','detailProformats.articles_id','=','articles.id')
            ->join('proformats','proformats.id','=','detailProformats.proformats_id')
            ->join('fournisseurs','fournisseurs.id','=','proformats.fournisseurs_id')
            ->select('detailProformats.quantite','detailProformats.prixUnitaire','articles.libelleArticle','articles.dernierPrix','fournisseurs.nomSociete','proformats.*')
            ->where('proformats.slug','=',$slug)
            ->get();
        $codeProformat="";
        $dateProformat="";
        $fournisseur="";
        $montant=0;
        foreach ($proformats as $proformat){
            $codeProformat = $proformat->codeProformat;
            $dateProformat = $proformat->dateProformat;
            $fournisseur=$proformat->nomSociete;
            $montant+=($proformat->quantite*$proformat->dernierPrix);
        }
        $pdf = PDF::loadView('proformats.print', compact('proformats','codeProformat','dateProformat','fournisseur','montant'))->setPaper('a4', 'portrait');

        $fileName = $codeProformat;

        return $pdf->stream($fileName . '.pdf');
       */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proformat  $proformat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proformat $proformat)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proformat  $proformat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proformat $proformat)
    {
        //
    }
}
