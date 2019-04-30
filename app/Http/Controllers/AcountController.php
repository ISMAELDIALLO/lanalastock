<?php

namespace App\Http\Controllers;

use App\Acount;
use App\Commande;
use App\LineDeCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MercurySeries\Flashy\Flashy;
use DateTime;
use PDF;

class AcountController extends Controller
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

        $acounts = DB::table('acounts')
                ->join('commandes','commandes.id','=','acounts.commandes_id')
                ->join('fournisseurs','fournisseurs.id','=','commandes.fournisseurs_id')
                ->select('commandes.codeCommande','commandes.dateCommande','fournisseurs.nomSociete','fournisseurs.nomDuContact','fournisseurs.prenomDuContact','acounts.*')
                ->get();
        return view('commandes.listAvanche',compact('acounts','demandes','demandes'));
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
     * @param  \App\Acount  $acount
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $acounts = DB::table('acounts')
                ->join('commandes','commandes.id','=','acounts.commandes_id')
                ->join('fournisseurs','fournisseurs.id','=','commandes.fournisseurs_id')
                ->where('acounts.id',$id)
                ->select('commandes.dateCommande','commandes.codeCommande','fournisseurs.nomSociete','fournisseurs.nomDuContact','fournisseurs.prenomDuContact','acounts.*')
                ->get();
        $codeCommande = "";
        $datePayement = "";
        $nomContact = "";
        $nomSociete ="";
        $prenomContact = "";
        $montantPayer = "";
        $referencePayement = "";

        foreach ($acounts as $acount){
            $codeCommande = $acount->codeCommande;
            $datePayement = $acount->datePayement;
            $nomSociete = $acount->nomSociete;
            $nomContact = $acount->nomDuContact;
            $prenomContact = $acount->prenomDuContact;
            $montantPayer = $acount->montantPaye;
            $referencePayement = $acount->referencePayement;

        }

        $pdf = PDF::loadView('commandes.printAvanche', compact('codeCommande','datePayement','referencePayement','nomSociete','nomContact','prenomContact','montantPayer'))->setPaper('a4', 'portrait');
        $fileName = $codeCommande;
        return $pdf->stream($fileName . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Acount  $acount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $commande = Commande::findOrFail($id);

        return view('commandes.payement', compact('demandes', 'commande'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Acount  $acount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$request->input('montantPaye')){
            Flashy::error('Le montant est obligatoire');
            return back();
        }

        $montants = DB::table('line_de_commandes')
            ->where('commandes_id','=',$id)
            ->select('quantite','prixUnitaire')
            ->get();

        $montantTotal = 0;
        foreach ($montants as $montant){
            $montantTotal += $montant->quantite*$montant->prixUnitaire;
        }

        $montantPaye = Acount::where('commandes_id',$id)->sum('montantPaye');

        $montantRestant = $montantTotal - $montantPaye;

        if ($request->input('montantPaye') > $montantRestant){
            Flashy::error('Il ne vous reste à payer que '.strrev(wordwrap(strrev($montantRestant), 3,' ',true)).' Francs');
            return back();
        }

        $refs = Acount::select(DB::raw("CONCAT('P00', MAX(CAST(RIGHT(referencePayement,LENGTH(referencePayement)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $re="P00";
        foreach ($refs as $ref){
            if ($ref->code){
                $re=$ref->code;
            }
        }

        $date = new DateTime();
        $acount = new Acount();
        $acount->referencePayement = $re;
        $acount->commandes_id = $id;
        $acount->datePayement = $date->format('Y-m-d');
        $acount->montantPaye = $request->input('montantPaye');
        $acount->users_id = auth()->user()->id;
        $acount->save();

        Flashy::success('payement effectué avec succès');

        $commande = Commande::findOrFail($id);
        if ($commande->cotations_id == null){
            return redirect()->route('commandeSpecifique');
        }

        return redirect()->route('commande.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Acount  $acount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acount $acount)
    {
        //
    }
}
