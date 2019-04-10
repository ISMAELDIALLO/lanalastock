<?php

namespace App\Http\Controllers;

use App\Article;
use App\Demande;
use App\DetailDemande;
use App\DetailSortieStock;
use App\Mail\EnvoiMailDemandeur;
use App\SortieStock;
use App\Stock;
use App\User;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use MercurySeries\Flashy\Flashy;

class SortieStockController extends Controller
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

        $sorties = DB::table('users')
            ->join('sortie_stocks','users.id','=','sortie_stocks.users_id')
            ->select(
                'sortie_stocks.*', 'users.nom', 'users.prenom', 'users.email'
            )
            ->get();
        return view('demandes.listSortieStock',compact('demandes', 'sorties'));
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
     * @param  \App\SortieStock  $sortieStock
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        /*
         *Ici La methode show retourne la vue pour saisir la quantite a affecter
         * */
        $detailDemande = DetailDemande::findOrFail($id);
        $articleDemande = Article::where('id', $detailDemande->articles_id)->first();
        $articleDemande = $articleDemande->libelleArticle;
        return view('demandes.quantiteSortante', compact('demandes', 'detailDemande', 'articleDemande'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SortieStock  $sortieStock
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //L'edit ici concerne juste la sortie dans le stock ça n'a rien à voir avec le update


        $date = new DateTime();

        $idDemande = Demande::where('codeDemande', $id)->first();

        //recuperation du mail de l'utilisateur qui a fait la demande
        $mailUser = User::findOrFail($idDemande->users_id)->email;


        $idDemande = $idDemande->id;
        //Modification du statut de la demande pour montrer que la demande a ete valide
        $demande = Demande::findOrFail($idDemande);
        $demande->statut = 1;
        $demande->etat = 1;
        $demande->save();

//        $detailDemande = DetailDemande::findOrFail($id);
//
//        $articleDemande = Article::findOrFail($detailDemande->articles_id)->libelleArticle;


        $details = DB::table('demandes')
            ->join('detail_demandes', 'demandes.id', '=', 'detail_demandes.demandes_id')
            ->where('demandes.id', $idDemande)
            ->select(
                'detail_demandes.quantiteDemandee',
                'detail_demandes.id AS detailDemandeId',
                'detail_demandes.articles_id'
            )
            ->get();

        //generation automatique du code de la sortie stock
        $sors=SortieStock::select(DB::raw("CONCAT('S00', MAX(CAST(RIGHT(codeSortie,LENGTH(codeSortie)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $sr="S001";
        foreach ($sors as $sor){
            if ($sor->code){
                $sr=$sor->code;
            }
        }

        //insertion dans la table sortie_stocks
        $sortie = new SortieStock();
        $sortie->codeSortie = $sr;
        $sortie->dateSortie = $date->format('Y-m-d');
        $sortie->users_id = auth()->user()->id;
        $sortie->save();
        //on recupere l'id de la sortie pour l'inserer dans detail_sortie_stocks
        $idSortie = SortieStock::max('id');

        foreach($details as $det){
            //selection du prix stock dans la table stock pour pour l'inserer dans sortiea_stocks
            $stock = Stock::where('articles_id', $det->articles_id)->first();
            //insertion dans la table sortie stock

            $sortieStock = new DetailSortieStock();
            $sortieStock->articles_id = $det->articles_id;
            $sortieStock->sortie_stocks_id = $idSortie;
            $sortieStock->quantiteSortante = session('quantiteAffectee'.$det->detailDemandeId);
            $sortieStock->detailDemandes_id = $det->detailDemandeId;
            $sortieStock->quantiteDemandee = $det->quantiteDemandee;
            $sortieStock->prix = session('quantiteAffectee'.$det->detailDemandeId)*$stock->prixStock;
            $sortieStock->save();

            //modification du stock
            if(Stock::where('articles_id', $det->articles_id)->first()){
                $stock = Stock::where('articles_id', $det->articles_id)->first();
                $stock->quaniteStock -= session('quantiteAffectee'.$det->detailDemandeId);
                $stock->save();
            }

        }

        //Objet
        $subjectUser = "Validation de demande";

        //message envoye a l'utilisateur qui a fait la demande
        $messageUser = "Votre demande d'article a ete validé.";

        Mail::to($mailUser)->send(new EnvoiMailDemandeur($subjectUser, $messageUser));
        Flashy::success('Sortie effectuez avec succes');
        return redirect()->route('sortieStock.index');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SortieStock  $sortieStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dans cette methode on recuperela quantite a affecter et on la stocke dans une variable de session

        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();
        //recuperation des details de la demande
        $detailDemande = DetailDemande::findOrFail($id);

        //Selection de la quantite disponible dans le stock
        $stocks = Stock::all()->count();
        if($stocks == 0){
            Session::flash('stockVide');
            return back();
        }else{
            if(Stock::where('articles_id',$detailDemande->articles_id)->first()){
                //Recuperation de la quantite minimale dans Article pour envoyer l'alerte

                $quantiteMinimum = Article::findOrFail($detailDemande->articles_id)->quantiteMinimum;

                //Recuperation de la quantite se trouvant dans le stock
                $stockId = Stock::where('articles_id',$detailDemande->articles_id)->first();
                $quantiteStock = $stockId->quaniteStock;

                //La quantite qui va rester après affectation que l'on doit comparer avec la quantite minimum dans Article
                $quantiteRestante = $quantiteStock - $request->input('quantite');

                //Comparaison entre la quantite du stock et celle saisie
                if($quantiteStock < $request->input('quantite')){
                    Session::flash('warning');
                    return back();
                }elseif ($quantiteRestante == $quantiteMinimum){
                     Flashy::error('Vous allez atteindre la quanite minimale');
                }elseif ($quantiteRestante < $quantiteMinimum){
                    Flashy::error('Vous êtes en dessous de la quantite minimale');
                }

                //Recuperation de la quantite a affectee dans une variable de session dont la cle est concatene a l'identifiant
                //du detail detail demande qui varie en fonction a chaque clique sur une autre ligne et yaura creation d'une nouvelle
                //variable session
                Session::put('quantiteAffectee'.$id, $request->input('quantite'));
            }else{
                //Si l'article n'existe pas dans le stock on enregistre zero dans la sortie

                Flashy::error("L'article ne se trouve pas dans le stock");
                Session::put('quantiteAffectee'.$id, 0);
            }

            return redirect()->route('demande.show', $detailDemande->demandes_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SortieStock  $sortieStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(SortieStock $sortieStock)
    {
        //
    }
}
