<?php

namespace App\Http\Controllers;

use App\Compte;
use App\ComptePrincipal;
use App\DetailCompte;
use App\Societe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use DateTime;

class DetailCompteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //L'affichage du compte principal
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page
        $demandes= nonConsult();

        $comptePrincipals = ComptePrincipal::all();
        $comptes = Compte::all();
        return view('comptes.comptePrincipal',compact('demandes','comptePrincipals','comptes'));

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
        //dd('liquider');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailCompte  $detailCompte
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page
        $demandes= nonConsult();

        $details = DB::table('comptes')
                ->join('detail_comptes','comptes.id','=','detail_comptes.comptes_id')
                ->where('detail_comptes.comptes_id','=',$id)
                ->select(DB::raw('sum(detail_comptes.montant) as montant'),'detail_comptes.date','comptes.compte')
                ->groupBy('detail_comptes.date','comptes.compte')
                ->get();
        $comptes = "";
        foreach ($details as $detail){
            $comptes = $detail->compte;
        }
        return view('comptes.detail',compact('demandes','details','comptes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailCompte  $detailCompte
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes= nonConsult();

        $comptePrincipals = ComptePrincipal::findOrFail($id);

        $comptes = Compte::all();


        return view('comptes.liquider',compact('demandes','comptePrincipals', 'comptes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailCompte  $detailCompte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //La date du jour pour l'inserer dans detail_comptes
        $date = new DateTime();

        $comptePrincipals = ComptePrincipal::findOrFail($id);

        $montantP = $comptePrincipals->montant;
        //cette selection ramene l'ensemble des lignes de comptes avec le pourcentage de la societe
        //qui correspond a chaque compte
        $compteSocietes = DB::table('societes')
            ->join('comptes','societes.id','=','comptes.societes_id')
            ->select('societes.pourcentage','comptes.*')
            ->get();

        //on parcourt toutes les lignes de comptes pour effectuer la mise a jour du montant et
        //on vide le compte principal
       foreach ($compteSocietes as $compteSociete){
           $comptes = Compte::findOrFail($compteSociete->id);
           $comptes->montant +=$montantP*$compteSociete->pourcentage/100;
           $comptes->save();

           //insertion dans detail_compte
           $detailCompte = new DetailCompte();

           $detailCompte->comptes_id = $compteSociete->id;
           $detailCompte->montant = $montantP*$compteSociete->pourcentage/100;
           $detailCompte->date = $date->format('Y-m-d');
           $detailCompte->save();
       }
        $comptePrincipals->truncate();
        return redirect()->route('compte.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailCompte  $detailCompte
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailCompte $detailCompte)
    {
        //
    }
}
