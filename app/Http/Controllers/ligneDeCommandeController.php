<?php

namespace App\Http\Controllers;

use App\Article;
use App\Commande;
use App\Fournisseur;
use App\Http\Requests\commandeFormResquest;
use App\LineDeCommande;
use App\Stock;
use App\tableTemporaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \DateTime;
use Illuminate\Support\Facades\Session;

class ligneDeCommandeController extends Controller
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

        $commandes=DB::table('commandes')
            ->join('line_de_commandes','commandes.id','=','line_de_commandes.commandes_id')
            ->join('articles','articles.id','line_de_commandes.articles_id')
            ->select('articles.referenceArticle','articles.libelleArticle','commandes.codeCommande','dateCommande','line_de_commandes.*')
            ->get();
        return view('ligneDeCommandes.list',compact('commandes', 'demandes'));
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
        $lignes=DB::table('articles')
            ->join('table_temporaires','articles.id','=','table_temporaires.articles')
            ->select('articles.libelleArticle','articles.dernierPrix','table_temporaires.*')
            ->get();
        return view('ligneDeCommandes.create',compact('fournisseurs','lignes', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(commandeFormResquest $request)
    {
       //dd('hee u es la');
        $date=new DateTime();
        //Enregistrement de la commande
        $coms=Commande::select(DB::raw("CONCAT('CM0', MAX(CAST(RIGHT(codeCommande,LENGTH(codeCommande)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $cm="CM01";
        foreach ($coms as $com){
            if ($com->code){
                $cm=$com->code;
            }
        }
        $commandes=new Commande();
        $commandes->fournisseurs_id=$request->input('fournisseur');
        $commandes->codeCommande=$cm;
        $commandes->dateCommande=$request->input('dateCommande');
        $commandes->slug=$request->input('dateCommande').$date->format('YmdHis');
        $commandes->save();

        //Selection de l'identifiant de la commande
        $idCommande=Commande::max('id');
        /*Insertion dans ligne de commande, tanque ya d'enregistrement dans la table temporaire on insert dans la table
         ligne de commande et à chque fois on un nouvel objet et apres insertion on supprime les données dans la table temporaire
        */
        $tableTemporaires=tableTemporaire::all();
        foreach ($tableTemporaires as $tableTemporaire){
            $ligneCommande=new LineDeCommande();
            $ligneCommande->commandes_id=$idCommande;
            $ligneCommande->articles_id=$tableTemporaire->articles;
            $ligneCommande->quantite=$tableTemporaire->quantite;
            $ligneCommande->prixUnitaire = Article::findOrFail($tableTemporaire->articles)->dernierPrix;
            $ligneCommande->slug=$tableTemporaire->articles.$date->format('YmdHis');
            $ligneCommande->save();
        }
        //Vider la table temporaire
        tableTemporaire::truncate();
        return redirect()->route('commande.index');
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
    public function edit($slug)
    {

        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        //selection des articles
        $articles = Article::all();

        //la ligne de commande que nous voulons modifier
        $commandes = LineDeCommande::where('slug',$slug)->first();

        return view('ligneDeCommandes.edit', compact('articles', 'commandes', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //dd($slug);
        $date=new DateTime();//pour initialiser le slug dans la table stock
        //quantite maximale a ne pas depasser se trouvant dans articles
        $quantiteMaximum = Article::findOrFail($request->input('article'))->quantiteMaximum;

        //le stock a modifier
        $stockStock = Stock::where('articles_id', $request->input('article'))->first();
        //la quantite dans le stock
        $quantiteStock = 0;
        if ($stockStock){
            $quantiteStock = $stockStock->quaniteStock;
        }

        //quantite disponible apres la modification
        $nouvelleQuantite = $quantiteStock + $request->input('quantite');

        //si la nouvelle quantite est superieur a la nouvelle quantite on ramene un message d'alerte
        if($nouvelleQuantite > $quantiteMaximum){
            Session::flash('quantiteDepassee');
            return back();
        }
        //Enregistrement des modifications dans ligne_de_commandes

        $commande = LineDeCommande::where('slug', $slug)->first();
        $commande->articles_id = $request->input('article');
        $commande->quantite = $request->input('quantite');
        $commande->save();

        return redirect()->route('ligneDeCommande.index',compact('commande'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {

        LineDeCommande::where('slug', $slug)->first()->delete();
        return back();
    }
}
