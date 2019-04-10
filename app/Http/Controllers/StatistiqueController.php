<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StatistiqueController extends Controller
{
    public function coutsParService(){

        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $couts = DB::table('societes')
            ->join('services', 'societes.id', '=', 'services.societes_id')
            ->join('users', 'services.id', '=', 'users.services_id')
            ->join('demandes', 'users.id', '=', 'demandes.users_id')
            ->join('sortie_stocks', 'demandes.id', '=', 'sortie_stocks.demandes_id')
            ->select(DB::raw('SUM(sortie_stocks.prix) as cout') , 'services.service','societes.nomSociete','services.pourcentage','services.pourcentage_vie')
            ->groupBy(DB::raw("services.service,societes.nomSociete,services.pourcentage,services.pourcentage_vie"))
            ->get();
        return view('couts.coutParService', compact('couts', 'demandes'));
    }

    public function rechercher(Request $request){

        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        Session::put('dateDebut', $request->input('dateDebut'));
        Session::put('dateFin', $request->input('dateFin'));

        $comptes = DB::table('comptes')
            ->join('detail_comptes', 'comptes.id', '=', 'detail_comptes.comptes_id')
            ->whereBetween('detail_comptes.date', array($request->input('dateDebut'), $request->input('dateFin')))
            ->select(DB::raw('SUM(detail_comptes.montant) as montant'),'comptes.id', 'comptes.compte')
            ->groupBy(DB::raw("comptes.compte, comptes.id"))
            ->get();

        $titre = "Couts par Societe ente le " . $request->input('dateDebut') . " et le " . $request->input('dateFin');
        return view('comptes.list',compact('demandes','comptes', 'titre'));
    }

    public function printCouts(Request $request){
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $couts = DB::table('societes')
            ->join('services', 'societes.id', '=', 'services.societes_id')
            ->join('users', 'services.id', '=', 'users.services_id')
            ->join('demandes', 'users.id', '=', 'demandes.users_id')
            ->join('sortie_stocks', 'demandes.id', '=', 'sortie_stocks.demandes_id')
            ->whereBetween('sortie_stocks.dateSortie', array(session('dateDebut'), session('dateFin')))
            ->select(DB::raw('SUM(sortie_stocks.prix) as cout'),'sortie_stocks.dateSortie', 'services.service','societes.nomSociete','services.pourcentage','services.pourcentage_vie')
            ->groupBy(DB::raw("services.service,societes.nomSociete,services.pourcentage,services.pourcentage_vie,sortie_stocks.dateSortie"))
            ->get();

        return view('couts.print',compact('demandes', 'couts'));
    }
}
