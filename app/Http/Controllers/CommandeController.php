<?php

namespace App\Http\Controllers;

use App\Article;
use App\Commande;
use App\Cotation;
use App\Fournisseur;
use App\Http\Requests\commandeFormResquest;
use App\LineDeCommande;
use App\Mail\mailDaf;
use App\Parametre;
use App\tableTemporaire;
use \DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use MercurySeries\Flashy\Flashy;
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
            ->join('cotations', 'cotations.id', '=', 'commandes.cotations_id')
            ->where('commandes.etat', 1)
            ->select('fournisseurs.nomSociete','fournisseurs.nomDuContact','fournisseurs.prenomDuContact','fournisseurs.telephoneDuContact',
                'cotations.codeCotation','commandes.*')
            ->get();
        $comm = 1;
        $validation = 0;
        return view('commandes.liste',compact('commandes', 'demandes','comm','validation'));
    }

    public function listeDerniereCotation(){
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $commandes=DB::table('fournisseurs')
            ->join('commandes','fournisseurs.id','=','commandes.fournisseurs_id')
            ->join('cotations', 'cotations.id', '=', 'commandes.cotations_id')
            ->select('fournisseurs.nomSociete','fournisseurs.nomDuContact','fournisseurs.prenomDuContact','fournisseurs.telephoneDuContact',
                'cotations.codeCotation','commandes.*')
            ->where([
                ['commandes.cotations_id','=',Cotation::max('id')],
                ['commandes.etat','=',1]
            ])
            ->get();

        $comm = 0;
        return view('commandes.liste',compact('commandes', 'demandes','comm'));
    }

    public function commandeEnAttenteDeValidation()
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $commandes=DB::table('fournisseurs')
            ->join('commandes','fournisseurs.id','=','commandes.fournisseurs_id')
            ->select('fournisseurs.nomSociete','fournisseurs.nomDuContact','fournisseurs.prenomDuContact','fournisseurs.telephoneDuContact', 'commandes.*')
            ->where('commandes.etat',0)
            ->get();
        return view('commandes.cmdEnAttenteDeValidation',compact('commandes', 'demandes'));
    }

    public function listCommandeSpecifique(){
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $commandes=DB::table('fournisseurs')
            ->join('commandes','fournisseurs.id','=','commandes.fournisseurs_id')
            ->where([
                ['commandes.cotations_id', '=', null],
                ['commandes.etat', '=', 1]
            ])
            ->select('fournisseurs.nomSociete','fournisseurs.nomDuContact','fournisseurs.prenomDuContact',
                'fournisseurs.telephoneDuContact', 'commandes.*')
            ->get();

        return view('commandes.listCommandeSansCotation', compact('demandes', 'commandes'));

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

        $fournisseurs = Fournisseur::all();

        $articles = Article::all();

        $lignes = DB::table('articles')
                ->join('table_temporaires','table_temporaires.articles','=','articles.id')
                ->select('articles.libelleArticle','articles.referenceArticle','table_temporaires.*')
                ->get();

        return view('commandes.commandeSansCotation',compact('fournisseurs', 'demandes','articles','lignes'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        $commandes->users_id = auth()->user()->id;
        $commandes->etat = 0;
        $commandes->dateCommande = $date->format('Y-m-d');
        $commandes->slug=$request->input('dateCommande').$date->format('YmdHis');
        $commandes->save();

        //Envoi de mail au DAF
        $mailAudiraire = Parametre::findOrFail(1);
        $mailAudiraire = $mailAudiraire->mailAuditaire;
        $subject = "Validation d'une nouvelle commande";
        $messageAuditeur = "Vous avez une commande en attente de validation. Numero de la Commande : " . $cm;
        Mail::to($mailAudiraire)->send(new mailDaf($messageAuditeur, $subject));

        $idCommande = Commande::max('id');

        $temporaireCommandes = tableTemporaire::all();

        foreach ($temporaireCommandes as $temporaireCommande){
            $lineCommande = new LineDeCommande();
            $lineCommande->commandes_id = $idCommande;
            $lineCommande->articles_id = $temporaireCommande->articles;
            $lineCommande->quantite = $temporaireCommande->quantite;
            $lineCommande->prixUnitaire = $temporaireCommande->prixUnitaire;
            $lineCommande->slug = $date;
            $lineCommande->save();
        }

        tableTemporaire::truncate();
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

        $validation = 1;

        $details = DB::table('commandes')
            //->join('commandes', 'cotations.id', '=', 'commandes.cotations_id')
            ->join('line_de_commandes', 'commandes.id', '=', 'line_de_commandes.commandes_id')
            ->join('articles', 'articles.id', '=', 'line_de_commandes.articles_id')
            ->where('line_de_commandes.commandes_id', '=', $id)
            ->select('articles.libelleArticle', 'commandes.codeCommande', 'line_de_commandes.*')
            ->get();
        $commande = Commande::findOrFail($id);

        return view('commandes.details', compact('demandes', 'details','validation','commande'));
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
            ->where('line_de_commandes.commandes_id','=',$slug)
            ->get();
        $codeCommande="";
        $dateCommande="";
        $fournisseur="";
        $montant=0;
        $modePayement = "";
        foreach ($commandes as $commande){
            $codeCommande = $commande->codeCommande;
            $dateCommande = $commande->dateCommande;
            $modePayement = $commande->modePayement;
            $fournisseur = $commande->nomSociete;
            $montant+=($commande->quantite*$commande->dernierPrix);
        }

        $pdf = PDF::loadView('commandes.print', compact('commandes','codeCommande','dateCommande','modePayement','fournisseur','montant'))->setPaper('a4', 'portrait');
        $fileName = $codeCommande;
        return $pdf->stream($fileName . '.pdf');
    }

    public function conditionPayement($id){
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $commande = Commande::findOrFail($id);

        return view('commandes.conditionPayement', compact('commande', 'demandes'));
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
    public function update(Request $request, $id)
    {
        if($request->input('conditionPayement')){
            $commande = Commande::findOrFail($id);
            $commande->modePayement = $request->input('conditionPayement');
            $commande->save();

            Flashy::success('conditions de payement ajoutées avec succès');

            if ($commande->cotations_id == null){
                return redirect()->route('commandeSpecifique');
            }

            return redirect()->route('commande.index');
        }

        Flashy::error('Le champ condition de payement est requis');
        return back();
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
