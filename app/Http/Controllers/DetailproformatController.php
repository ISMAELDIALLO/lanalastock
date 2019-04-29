<?php

namespace App\Http\Controllers;

use App\Article;
use App\Commande;
use App\Detailproformat;
use App\Fournisseur;
use App\LineDeCommande;
use App\Mail\EnvoiMailAuditaire;
use App\Mail\EnvoiMailSuperieur;
use App\Parametre;
use App\Proformat;
use App\tableTemporaire;
use App\TemporaireProformat;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use MercurySeries\Flashy\Flashy;
use Psy\Output\ProcOutputPager;

class DetailproformatController extends Controller
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

        $fournisseurs=Fournisseur::all();
        /*
         * Selection des lignes de commande
         */

        return view('detailProformats.ajout',compact('fournisseurs', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $date=new DateTime();
        //Enregistrement de la commande

        $codePros=Proformat::select(DB::raw("CONCAT('CP0', MAX(CAST(RIGHT(codeProformat,LENGTH(codeProformat)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $pro="CP01";
        foreach ($codePros as $codePro){
            if ($codePro->code){
                $pro=$codePro->code;
            }
        }

        $proformats = new Proformat();
        $proformats->fournisseurs_id=$request->input('fournisseur');
        $proformats->codeProformat = $pro;
        $proformats->etat = 0;
        $proformats->dateProformat=$request->input('dateProformat');
        if ($request->hasFile('image')){
            $proformats->image=$request->file('image')->store('images');
        }
        $proformats->slug=$request->input('dateProformat').$date->format('YmdHis');

        $proformats->save();

        return redirect()->route('proformat.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Detailproformat  $detailproformat
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
     * @param  \App\Detailproformat  $detailproformat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page
        $demandes = nonConsult();

        $codeProformat = Proformat::where('codeProformat', $id)->first();

        $codeProformats = $codeProformat->codeProformat;

        return view('proformats.choisirProformat',compact('demandes','codeProformat','codeProformats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Detailproformat  $detailproformat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $proformat = Proformat::where('codeProformat',$id)->first();
        $proformat->commentaires = $request->input('commentaire');
        $proformat->etat = 1;
        $proformat->save();
        $codeProformat = $proformat->codeProformat;
        if (mailgestionnaire()==false){
            $parms=new Parametre();
            $parms->mailGestionnaire="ourybailo69@gmail.com";
            $parms->mailAuditaire="ourybailo69@gmail.com";
            $parms->save();
        }
        $parametres=Parametre::all();
        $mailAuditaire = "";
        foreach ($parametres as $parametre)
        {
            $mailAuditaire = $parametre->mailAuditaire;
        }

        $subject = "Choix de Facture Proformat";

        $messageAuditaire = "Vous avez une nouvelle facture à valider code : ".$codeProformat;

        Mail::to($mailAuditaire)->send(new EnvoiMailAuditaire($subject, $messageAuditaire));

        return redirect()->route('proformat.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Detailproformat  $detailproformat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
