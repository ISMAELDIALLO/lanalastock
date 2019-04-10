<?php

namespace App\Http\Controllers;

use App\Demande;
use App\DetailDemande;
use App\Mail\EnvoiMailGestionnaire;
use App\Mail\EnvoiMailSuperieur;
use App\message;
use App\Parametre;
use App\TemporaireDemande;
use App\User;
use App\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Mail;
use MercurySeries\Flashy\Flashy;


class DetailDemandeController extends Controller
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

        //$demandes = nonConsult();
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

        $date=new DateTime();
        $dateDemande = $date->format('Y-m-d');
        $lignes=DB::table('articles')
            ->join('temporaire_demandes','articles.id','=','temporaire_demandes.articles')
            ->select('articles.libelleArticle','temporaire_demandes.*')
            ->where('users',auth()->user()->id)
            ->get();
        return view('detailDemandes.create',compact('lignes','dateDemande', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Enregistrement de la demande
        $dems=Demande::select(DB::raw("CONCAT('DM0', MAX(CAST(RIGHT(codeDemande,LENGTH(codeDemande)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $dm="DM01";
        foreach ($dems as $dem){
            if ($dem->code){
                $dm=$dem->code;
            }
        }
        $demandes=new Demande();
        $demandes->codeDemande=$dm;
        $demandes->dateDemande=$request->input('dateDemande');
        $demandes->statut = 0;
        $demandes->users_id=auth()->user()->id;
        $demandes->save();

        //Selection de l'identifiant de la demande
        $idDemande=Demande::max('id');
        /*Insertion dans detail demande, tanque ya d'enregistrement dans la table temporaire Demande on insert dans la table
         detail Demande et à chque fois on un nouvel objet et apres insertion on supprime les données dans la table temporaire
        */
        $temporaireDemandes=TemporaireDemande::where('users',auth()->user()->id)->get();
        //dd($temporaireDemandes);
        foreach ($temporaireDemandes as $temporaireDemande){
            $detaliDemande=new DetailDemande();
            $detaliDemande->demandes_id=$idDemande;
            $detaliDemande->articles_id=$temporaireDemande->articles;
            $detaliDemande->quantiteDemandee=$temporaireDemande->quantiteDemandee;
            $detaliDemande->save();
        }

        //Vider la table temporaire
        TemporaireDemande::where('users',auth()->user()->id)->delete();

        //Envoi du mail
        //Recuperation du mail du superieur à travers l'identifiant de l'utilisateur connecté
        $mailSuperieur=User::findOrFail(auth()->user()->id)->emailSuperieur;

        //On verifie si le mail du gestionnaire n'existe pas à travers un helpers si non on le crée

        if (mailgestionnaire()==false){
            $parms=new Parametre();
            $parms->mailGestionnaire="ourybailo69@gmail.com";
            $parms->save();
        }
        $parametres=Parametre::all();
        $mailGestionnaire="";
        foreach ($parametres as $parametre)
        {
            $mailGestionnaire=$parametre->mailGestionnaire;
        }

        $msgGestionnaire = message::find(1)->messageGestionnaire;
        $msgSuperieur = message::find(1)->messageSuperieur;
        $subject="Demande d'acquisition d'articles";
        $messageSuperieur= auth()->user()->nom." ".auth()->user()->prenom." ".$msgSuperieur;
        $messageGestionnaire= auth()->user()->nom. " " .auth()->user()->prenom ." ".$msgGestionnaire." Numero demande : " . $dm;
        Mail::to($mailSuperieur)->send(new EnvoiMailSuperieur($subject,$messageSuperieur));
        Mail::to($mailGestionnaire)->send(new EnvoiMailGestionnaire($subject,$messageGestionnaire));

        Flashy::success('Demande enregistrer avec succes');
        return redirect()->route('detailDemande.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailDemande  $detailDemande
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $dems = DB::table('demandes')
                ->join( 'detail_demandes','detail_demandes.demandes_id','=','demandes.id')
                ->join('articles','detail_demandes.articles_id','=','articles.id')
                ->where('detail_demandes.demandes_id','=',$id)
                ->select('articles.libelleArticle','demandes.codeDemande','detail_demandes.*')
                ->get();
        $codeDemande = "";
            foreach ($dems as $demande){
                $codeDemande = $demande->codeDemande;
            }
            return view('demandes.show',compact('dems','codeDemande','demandes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailDemande  $detailDemande
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailDemande $detailDemande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailDemande  $detailDemande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailDemande $detailDemande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailDemande  $detailDemande
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailDemande $detailDemande)
    {
        //
    }
}
