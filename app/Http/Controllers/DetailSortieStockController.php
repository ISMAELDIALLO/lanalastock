<?php

namespace App\Http\Controllers;

use App\Compte;
use App\ComptePrincipal;
use App\Demande;
use App\DetailCompte;
use App\DetailSortieStock;
use App\Mail\EnvoiMailDemandeur;
use App\Societe;
use App\SortieStock;
use App\Stock;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use MercurySeries\Flashy\Flashy;
use DateTime;

class DetailSortieStockController extends Controller
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

        $sorties = DB::table('articles')
            //->join('users','services.id','=','users.services_id')
            //->join('demandes','users.id','=','demandes.users_id')
            //->join('detail_demandes','demandes.id','=','detail_demandes.demandes_id')
            //->join('sortie_stocks','detail_demandes.id','=','sortie_stocks.detailDemandes_id')
            ->join('sortie_stocks','articles.id','=','sortie_stocks.articles_id')
            ->join('users', 'users.id', '=', 'sortie_stocks.users_id')
            ->select(
                'articles.libelleArticle', 'sortie_stocks.*', 'users.nom', 'users.prenom', 'users.email'
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
     * @param  \App\DetailSortieStock  $detailSortieStock
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $details = DB::table('articles')
            //->join('users','services.id','=','users.services_id')
            //->join('demandes','users.id','=','demandes.users_id')
            //->join('detail_demandes','demandes.id','=','detail_demandes.demandes_id')
            ->join('detail_sortie_stocks','articles.id','=','detail_sortie_stocks.articles_id')
            ->join('sortie_stocks','detail_sortie_stocks.sortie_stocks_id','=','sortie_stocks.id')
            ->where('detail_sortie_stocks.sortie_stocks_id', '=', $id)
            ->select('articles.libelleArticle', 'sortie_stocks.codeSortie', 'detail_sortie_stocks.*')
            ->get();

        $codeSortie = "";
        foreach ($details as $detail){
            $codeSortie = $detail->codeSortie;
        }

        return view('demandes.detailsSortie',compact('demandes', 'details', 'codeSortie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailSortieStock  $detailSortieStock
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailSortieStock  $detailSortieStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $societes = Societe::all();

        $nomS = "";
         $nombre =0;
        foreach ($societes as $societe){
           if ($request->input($societe->id)){
               $nomS = $request->input($societe->id);
               $nombre++;
           }
        }
        if (!$nomS){
            Flashy::error('Veuillez selectionner au moins societe');
            return back();
        }

        //L'update ici concerne juste la sortie dans le stock ça n'a rien à voir avec la modification


        $date = new DateTime();

        $dateDuJour = $date->format('Y-m-d');

        $idDemande = Demande::where('codeDemande', $id)->first();

        //recuperation du mail de l'utilisateur qui a fait la demande
        $mailUser = User::findOrFail($idDemande->users_id)->email;


        $idDemande = $idDemande->id;
        //Modification du statut de la demande pour montrer que la demande a ete valide
        $demande = Demande::findOrFail($idDemande);
        $demande->statut = 1;
        $demande->etat = 1;
        $demande->save();

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
            //selection de l'article dans le  stock  pour pour avoir son prix en stock i.e stocks->prixStock;
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

            $test = DetailCompte::where('date', $dateDuJour)->first();
            //insertion dans compte si toutes les societes ont été cochée
            if ($nombre == $societe->count()){
                //Si aumoins un enregistrement existe on fait une mise à jour de son montant
                if (ComptePrincipal::all()->count()>0){

                    $comptePrincipal = ComptePrincipal::findOrFail(1);
                    $comptePrincipal->montant += session('quantiteAffectee'.$det->detailDemandeId)*$stock->prixStock;
                    $comptePrincipal->save();
                }else{
                    //Sinon on on crée une nouvelle ligne
                    $comptePrincipal = new ComptePrincipal();
                    $comptePrincipal->montant = session('quantiteAffectee'.$det->detailDemandeId)*$stock->prixStock;
                    $comptePrincipal->save();
                }
            }else{
                foreach ($societes as $societe){
                    if ($request->input($societe->id)){

                        //Recuperation de l'identifiant du compte pour l'inserer dans detail compte à travers l'identifiant
                        //de la societe selectionnée. La boucle foreach nous permet d'aller chercher la
                        // societe cocher dans la table compte

                        $idCompte = Compte::where('societes_id',$request->input($societe->id))->first();
                        $idCompte = $idCompte->id;

                        //ajout dans detail compte
                         $detail = new DetailCompte();
                         $detail->comptes_id = $idCompte;
                         $detail->montant = session('quantiteAffectee'.$det->detailDemandeId)*$stock->prixStock;
                         $detail->date = $dateDuJour;
                         $detail->save();

                         // On alimente le compte par societe qui est la somme des montants du detailCompte
                         $compte = Compte::findOrFail($idCompte);
                         $compte->montant += session('quantiteAffectee'.$det->detailDemandeId)*$stock->prixStock;
                         $compte->save();
                    }
                }

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
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailSortieStock  $detailSortieStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailSortieStock $detailSortieStock)
    {
        //
    }
}
