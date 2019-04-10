<?php

namespace App\Http\Controllers;

use App\Article;
use App\Demande;
use App\DetailDemande;
use App\Mail\EnvoiMailDemandeur;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResetDemandeController extends Controller
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $resetDem=DetailDemande::findOrFail($id);
        return view('demandes.motifReset',compact('demandes','resetDem'));
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
        $detailDem = DetailDemande::findOrFail($id);
        $detailDem->statut = -1;
        $detailDem->save();

        //recuperation du code de la demande a travers son identifiant se trouvant dans la lligne de detail_demande rejetée
        $demande = Demande::findOrFail($detailDem->demandes_id);
        $codeDem = $demande->codeDemande;

        //recuperation de l'email de l'utilisateur qui a fait la demande
        $emailDemandeur = User::findOrFail($demande->users_id)->email;

        //recuperation de l'article rejeté
        $article = Article::findOrFail($detailDem->articles_id);
        $libelleArticle = $article->libelleArticle;
        //on envoie un mail au demandeur
        $subject = "Reponse à votre demande N° : " . $codeDem;
        $message = "Bonjour, votre demande d'acquisition de : " . $libelleArticle . ' a été rejetée. Le motif est : '
            .$request->input('motif');
        Mail::to($emailDemandeur)->send(new EnvoiMailDemandeur($subject, $message));
        $detailDem->delete();
        return redirect()->route('demande.show', $demande->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
