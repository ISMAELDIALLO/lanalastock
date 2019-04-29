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

    public function createCommande($id){
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $fournisseurs=Fournisseur::all();
        /*
         * Selection des lignes de commande
         */
        $lignes=DB::table('articles')
            ->join('detail_cotations','articles.id','=','detail_cotations.articles_id')
            ->join('cotations','cotations.id','=','detail_cotations.cotations_id')
            ->select('articles.libelleArticle','articles.referenceArticle','cotations.codeCotation','detail_cotations.*')
            ->where('detail_cotations.cotations_id',$id)
            ->get();


        Session::put('idCotation',$id);
        return view('ligneDeCommandes.create',compact('fournisseurs','lignes', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $date = new DateTime();

        //dd($request->input('article'));

        $lignes=DB::table('articles')
            ->join('detail_cotations','articles.id','=','detail_cotations.articles_id')
            ->join('cotations','cotations.id','=','detail_cotations.cotations_id')
            ->select('articles.libelleArticle','articles.dernierPrix','cotations.codeCotation','detail_cotations.*')
            ->where('detail_cotations.cotations_id',session('idCotation'))
            ->get();
       foreach ($lignes as $ligne){
           $temp = new tableTemporaire();
           if ($request->input('prixUnitaire'.$ligne->id)){
//               $testCommande = Commande::where([
//                   'cotations_id' => session('idCotation'),
//                   'fournisseurs_id' => $request->input('fournisseur'.$ligne->id)
//               ])->get();

               $testCommande = DB::table('commandes')
                   ->where([
                       ['cotations_id', session('idCotation')],
                       ['fournisseurs_id', $request->input('fournisseur'.$ligne->id)]
                   ])
                   ->select('commandes.*')->get();


               if($testCommande->count() > 0){
                   //on recupere l'id de la commande pour l'inserer dans la ligne de commande
                   $idC = 0;
                   foreach($testCommande as $test){
                       $idC = $test->id;
                   }
                   $ligneCommande = new LineDeCommande();
                   $ligneCommande->commandes_id = $idC;
                   $ligneCommande->articles_id = $ligne->articles_id;
                   $ligneCommande->quantite = $ligne->quantite;
                   $ligneCommande->prixUnitaire = $request->input('prixUnitaire'.$ligne->id);
                   $ligneCommande->slug = $ligne->articles_id.$date->format('YmdHis');
                   $ligneCommande->save();

               }else{
                   //Enregistrement de la commande
                   $coms=Commande::select(DB::raw("CONCAT('CM0', MAX(CAST(RIGHT(codeCommande,LENGTH(codeCommande)-3) AS UNSIGNED))+1) AS code"))
                       ->get();
                   $cm="CM01";
                   foreach ($coms as $com){
                       if ($com->code){
                           $cm=$com->code;
                       }
                   }

                   //dans le cas contraire on cree la commande et la ligne de commande
                   $commandes=new Commande();
                   $commandes->fournisseurs_id=$request->input('fournisseur'.$ligne->id);
                   $commandes->cotations_id = session('idCotation');
                   $commandes->users_id = auth()->user()->id;
                   $commandes->codeCommande=$cm;
                   $commandes->dateCommande=$date->format('Y-m-d');
                   $commandes->slug=$request->input('dateCommande').$date->format('YmdHis');
                   $commandes->save();

                   //on insere dans ligne aussi

                   $ligneCommande = new LineDeCommande();
                   $ligneCommande->commandes_id = Commande::max('id');
                   $ligneCommande->articles_id = $ligne->articles_id;
                   $ligneCommande->quantite = $ligne->quantite;
                   $ligneCommande->prixUnitaire = $request->input('prixUnitaire'.$ligne->id);
                   $ligneCommande->slug = $ligne->articles_id . $date->format('YmdHis');
                   $ligneCommande->save();
               }
           }
       }
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
