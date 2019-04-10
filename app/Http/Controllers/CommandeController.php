<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Fournisseur;
use App\Http\Requests\commandeFormResquest;
use \DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class CommandeController extends Controller
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

        $commandes=DB::table('fournisseurs')
            ->join('commandes','fournisseurs.id','=','commandes.fournisseurs_id')
            ->select('fournisseurs.nomSociete','fournisseurs.nomDuContact','fournisseurs.prenomDuContact','fournisseurs.telephoneDuContact','commandes.*')
            ->get();
        return view('commandes.liste',compact('commandes', 'demandes'));
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
        return view('commandes.create',compact('fournisseurs', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(commandeFormResquest $request)
    {
        $coms=Commande::select(DB::raw("CONCAT('CM0', MAX(CAST(RIGHT(codeCommande,LENGTH(codeCommande)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $cm="CM01";
        foreach ($coms as $com){
            if ($com->code){
                $cm=$com->code;
            }
        }
        $date=new DateTime();
        $commandes=new Commande();
        $commandes->fournisseurs_id=$request->input('fournisseur');
        $commandes->codeCommande=$cm;
        $commandes->dateCommande=$request->input('dateCommande');
        $commandes->slug=$request->input('dateCommande').$date->format('YmdHis');
        $commandes->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $details = DB::table('commandes')
            ->join('line_de_commandes', 'commandes.id', '=', 'line_de_commandes.commandes_id')
            ->join('articles', 'articles.id', '=', 'line_de_commandes.articles_id')
            ->where('line_de_commandes.commandes_id', '=', $id)
            ->select('articles.libelleArticle', 'commandes.codeCommande', 'line_de_commandes.*')
            ->get();

        $codeCommande = "";
        foreach ($details as $detail){
            $codeCommande = $detail->codeCommande;
        }

        return view('commandes.details', compact('demandes', 'details', 'codeCommande'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $commandes=DB::table('articles')
            ->join('line_de_commandes','line_de_commandes.articles_id','=','articles.id')
            ->join('commandes','commandes.id','=','line_de_commandes.commandes_id')
            ->join('fournisseurs','fournisseurs.id','=','commandes.fournisseurs_id')
            ->select('line_de_commandes.quantite','line_de_commandes.prixUnitaire','articles.libelleArticle','articles.dernierPrix','fournisseurs.nomSociete','commandes.*')
            ->where('commandes.slug','=',$slug)
            ->get();
        $codeCommande="";
        $dateCommande="";
        $fournisseur="";
        $montant=0;
        foreach ($commandes as $commande){
            $codeCommande=$commande->codeCommande;
            $dateCommande=$commande->dateCommande;
            $fournisseur=$commande->nomSociete;
            $montant+=($commande->quantite*$commande->dernierPrix);
        }

        $pdf = PDF::loadView('commandes.print', compact('commandes','codeCommande','dateCommande','fournisseur','montant'))->setPaper('a4', 'portrait');
        $fileName = $codeCommande;
        return $pdf->stream($fileName . '.pdf');
    }

    public function pdfExport($id){
        $commandes=DB::table('articles')
            ->join('line_de_commandes','line_de_commandes.articles_id','=','articles.id')
            ->join('commandes','commandes.id','=','line_de_commandes.commandes_id')
            ->join('fournisseurs','fournisseurs.id','=','commandes.fournisseurs_id')
            ->select('line_de_commandes.quantite','line_de_commandes.prixUnitaire','articles.libelleArticle','articles.dernierPrix','fournisseurs.nomSociete','commandes.*')
            ->where('commandes.slug','=',$id)
            ->get();
        $codeCommande="";
        $dateCommande="";
        $fournisseur="";
        $montant=0;
        foreach ($commandes as $commande){
            $codeCommande=$commande->codeCommande;
            $dateCommande=$commande->dateCommande;
            $fournisseur=$commande->nomSociete;
            $montant+=($commande->quantite*$commande->dernierPrix);
        }

        $pdf = PDF::loadView('commandes.print', compact( 'details', 'codeInventaire', 'dateInventaire'))->setPaper('a4', 'portrait');
        $fileName = $codeCommande;
        return $pdf->stream($fileName . '.pdf');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(commandeFormResquest $request, $slug)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {

    }
}
