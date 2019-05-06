<?php

namespace App\Http\Controllers;

use App\Article;
use App\Demande;
use App\LineDeCommande;
use App\Societe;
use App\Stock;
use App\temportaireSortieStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use DateTime;

class DemandeController extends Controller
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

        $listdemandes = DB::table('users')
            ->join('demandes', 'users.id', '=', 'demandes.users_id')
            ->select(
                'users.nom', 'users.prenom', 'users.email', 'users.emailSuperieur', 'demandes.*'
            )
            ->orderBy('demandes.id', 'desc')
            ->get();
        //Changement du l'etat de la demande

        /*$demande = Demande::where('id',$listdemandes->demandes_id);
        $demande->etat = 1;
        $demande->save();*/
        //Fin du changement de l'etat de la demande
        return view('demandes.liste', compact('demandes', 'listdemandes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        //on selectionne les donnees de la table societes
        $societes = Societe::all();

        //dd(session('quantiteAffectee'));

        //recuperation des infos de la demande en detail
        $details = DB::table('users')
            ->join('demandes', 'users.id', '=', 'demandes.users_id')
            ->join('detail_demandes', 'demandes.id', '=', 'detail_demandes.demandes_id')
            ->join('articles', 'articles.id', '=', 'detail_demandes.articles_id')
            //->join('stocks','stocks.articles_id','=','articles.id')
            ->where('demandes.id', $id)
            ->select(
                'users.nom', 'users.prenom', 'users.email', 'users.emailSuperieur','users.nomSuperieur',
                'articles.libelleArticle', 'articles.id AS idArticle', 'detail_demandes.quantiteDemandee','detail_demandes.articles_id',
                'detail_demandes.id AS detailDemandeId','demandes.*'
            )
            ->get();

        $stocks = Stock::all();
        $codeDemande = "";
        $nom = "";
        $prenom = "";
        $email = "";
        $nomSuperieur = "";
        foreach($details as $det){
            $codeDemande = $det->codeDemande;
            $nom = $det->nom;
            $prenom = $det->prenom;
            $nomSuperieur = $det->nomSuperieur;
        }

        return view('demandes.detail', compact('societes','details', 'demandes', 'codeDemande', 'nom', 'prenom', 'email', 'nomSuperieur', 'stocks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Ici on change l'etat de la demande à 1 lorsqu'elle est consultée
        //Pour que la decrementation s'effectue dans l'icone des notification
        //dd('edit dem');

        $dem = Demande::findOrFail($id);
        $dem->etat = 1;
        $dem->save();

        //on retourne la methode show pour afficher les details de la demande
        return redirect()->route('demande.show', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //dd($slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demande $demande)
    {
        //
    }
}
