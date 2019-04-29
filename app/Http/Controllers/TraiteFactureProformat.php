<?php

namespace App\Http\Controllers;

use App\Mail\EnvoiMailSuperieur;
use App\Mail\rejetterFacture;
use App\Mail\RepondreGestionnaire;
use App\Parametre;
use App\Proformat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TraiteFactureProformat extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Afficher les factures proformats à valider

        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $proformats=DB::table('fournisseurs')
            ->join('proformats','fournisseurs.id','=','proformats.fournisseurs_id')
            ->select('fournisseurs.nomSociete','fournisseurs.nomDuContact','fournisseurs.prenomDuContact','fournisseurs.telephoneDuContact','proformats.*')
            ->where('proformats.etat',1)
            ->get();

        return view('proformatAvaliders.listProformat',compact('proformats', 'demandes'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $details = Proformat::where('codeProformat',$id)->first();

        return view('proformatAvaliders.details', compact('demandes','details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       //Validation de la facture proformat

        $proformat = Proformat::where('codeProformat',$id)->first();
        $proformat->etat = 2;
        $proformat->save();
        $codeProformat = $proformat->codeProformat;
        if (mailgestionnaire()==false){
            $parms=new Parametre();
            $parms->mailGestionnaire="ourybailo69@gmail.com";
            $parms->mailAuditaire="ourybailo69@gmail.com";
            $parms->save();
        }
        $parametres=Parametre::all();
        $mailGestionnaire = "";
        foreach ($parametres as $parametre)
        {
            $mailGestionnaire = $parametre->mailGestionnaire;
        }

        $subject = "Valider de Facture Proformat";

        $messageGestionnaire= "Votre choix à été valider Code Facture : ".$codeProformat;

        Mail::to($mailGestionnaire)->send(new RepondreGestionnaire($subject, $messageGestionnaire));

        return redirect()->route('traiteFacture.index');
    }

    public function rejettrerProformat($id){
        // Rejetter les factures proformats

        $proformats = Proformat::where('codeProformat',$id)->first();

        $proformats->etat = 0;

        $proformats->save();



        $codeProformat = $proformats->codeProformat;
        if (mailgestionnaire()==false){
            $parms=new Parametre();
            $parms->mailGestionnaire="ourybailo69@gmail.com";
            $parms->mailAuditaire="ourybailo69@gmail.com";
            $parms->save();
        }
        $parametres=Parametre::all();
        $mailGestionnaire = "";
        foreach ($parametres as $parametre)
        {
            $mailGestionnaire = $parametre->mailGestionnaire;
        }

        $subject = "Rejetter de Facture Proformat";

        $messageGestionnaire= "Votre choix à été rejetter Code Facture : ".$codeProformat;

        Mail::to($mailGestionnaire)->send(new rejetterFacture($subject, $messageGestionnaire));
        return redirect()->route('traiteFacture.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
