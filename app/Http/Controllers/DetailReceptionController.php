<?php

namespace App\Http\Controllers;

use App\Acount;
use App\Article;
use App\Commande;
use App\DetailReception;
use App\Fournisseur;
use App\LineDeCommande;
use App\Reception;
use App\Stock;
use App\TemporaireReception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Session;
use MercurySeries\Flashy\Flashy;

class DetailReceptionController extends Controller
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

        $receptions=DB::table('receptions')
            ->join('detail_receptions','receptions.id','=','detail_receptions.receptions_id')
            ->join('articles','articles.id','detail_receptions.articles_id')
            ->select('articles.referenceArticle','articles.libelleArticle','receptions.codeReception','dateReception','detail_receptions.*')
            ->get();
        return view('detailReceptions.list',compact('receptions', 'demandes'));
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
         * Selection des lignes de reception
         */
        $lignes=DB::table('articles')
            ->join('temporaire_receptions','articles.id','=','temporaire_receptions.articles')
            ->select('articles.libelleArticle','temporaire_receptions.*')
            ->get();
        return view('detailReceptions.create',compact('fournisseurs','lignes', 'demandes'));
    }

    public  function  creationBonApayer1(){
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $lignes = null;
        return view('detailReceptions.create',compact('demandes','lignes'));
    }
    public function creationBonApayer(Request $request){
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        if ($request->input('numeroCommande')){
            $ligneCommandes = Commande::where('codeCommande',$request->input('numeroCommande'))->first();

            $idCommande = $ligneCommandes->id;

            Session::put('idCommande',$idCommande);
        }

        $lignes = DB::table('commandes')
            ->join('line_de_commandes','line_de_commandes.commandes_id','=','commandes.id')
            ->join('articles','articles.id','=','line_de_commandes.articles_id')
            ->join('fournisseurs','fournisseurs.id','commandes.fournisseurs_id')
            ->where('line_de_commandes.commandes_id', '=', session('idCommande'))
            ->select('articles.referenceArticle','articles.libelleArticle','line_de_commandes.quantite',
                        'line_de_commandes.prixUnitaire','fournisseurs.nomSociete','fournisseurs.nomDuContact',
                        'fournisseurs.prenomDuContact','line_de_commandes.*','commandes.codeCommande')
            ->get();
        $fournisseur = "";
        $codeCommande = "";
        foreach ($lignes as $ligne){
            $fournisseur = $ligne->nomSociete." ".$ligne->nomDuContact." ".$ligne->prenomDuContact;
            $codeCommande = $ligne->codeCommande;
        }
        return view('detailReceptions.create',compact('fournisseur','codeCommande','demandes','lignes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lignes = DB::table('commandes')
            ->join('line_de_commandes','line_de_commandes.commandes_id','=','commandes.id')
            ->join('articles','articles.id','=','line_de_commandes.articles_id')
            ->join('fournisseurs','fournisseurs.id','commandes.fournisseurs_id')
            ->where('line_de_commandes.commandes_id', '=', session('idCommande'))
            ->select('articles.referenceArticle','articles.libelleArticle','line_de_commandes.quantite',
                'line_de_commandes.prixUnitaire','fournisseurs.nomSociete','fournisseurs.nomDuContact',
                'fournisseurs.prenomDuContact','line_de_commandes.*','commandes.codeCommande')
            ->get();

        $montantEncoursDeLivraison = 0;
        foreach ($lignes as $ligne){
            if (!$request->input('quantiteLivree'.$ligne->id)){
                Flashy::error('La quantite livree est requise');
                return redirect()->route('creationBonApayer');
            }
            $montantEncoursDeLivraison += $request->input('quantiteLivree'.$ligne->id)*$ligne->prixUnitaire;
        }


        foreach ($lignes as $ligne){
            $quantiteDejaLivree = DB::table('commandes')
                ->join('detail_receptions', 'commandes.id', '=', 'detail_receptions.commandes_id')
                //->join('detail_receptions', 'receptions_id', '=', 'detail_receptions.receptions_id')
                ->where([
                    ['detail_receptions.commandes_id', '=', session('idCommande')],
                    ['detail_receptions.articles_id', '=', $ligne->articles_id]
                ])
                ->sum('quantite');

            //echo $quantiteDejaLivree.'<br>';
            $quantiteLivree = $quantiteDejaLivree + $request->input('quantiteLivree'.$ligne->id);

            if ($quantiteLivree > $ligne->quantite){
                Flashy::error('Quantite trop grande, il reste : '.($ligne->quantite-$quantiteDejaLivree)." ".$ligne->libelleArticle." à livrer");
                return redirect()->route('creationBonApayer');
            }
        }
        //on recupere le montant deja paye en avance pour cette commande
        $montantAvance = Acount::where('commandes_id', session('idCommande'))->sum('montantPaye');


        //recuperation de la valeur du montant de ce qui est livre et le montant paye concernant cette commande
        $recepts = DetailReception::where('commandes_id', session('idCommande'))->get();

        $sumMontantApayer = Reception::where('commandes_id', session('idCommande'))->sum('montantApayer');

        $montantRecu = 0;

        foreach ($recepts as $recept){
            $montantRecu += $recept->quantite*$recept->prixUnitaire;
        }

        $montantRecu += $montantEncoursDeLivraison;

        //Le montant paye en avance plus le montant paye lors des precedentes livraisons concernant cette commande
        $montantDejaPayer = $montantAvance + $sumMontantApayer;

        //On calcule le montant a payer pour cette livraison pour qu'on l'insere dans la table receptions
        $montantApayer = $montantRecu - $montantDejaPayer;

        if ($montantApayer < 0){
            Flashy::error('Cette livraison ne couvre pas le montant payé en avance');
            return redirect()->route('creationBonApayer');
        }

        $date = new DateTime();
        //Enregistrement de la commande
        $recs=Reception::select(DB::raw("CONCAT('RC0', MAX(CAST(RIGHT(codeReception,LENGTH(codeReception)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $rc="RC01";
        foreach ($recs as $rec){
            if ($rec->code){
                $rc=$rec->code;
            }
        }
        $receptions=new Reception();
        $receptions->codeReception = $rc;
        $receptions->dateReception = $date->format('Y-m-d');
        $receptions->users_id = auth()->user()->id;
        $receptions->commandes_id = session('idCommande');
        $receptions->montantApayer = $montantApayer;
        $receptions->slug=$request->input('dateReception').$date->format('YmdHis');
        $receptions->save();

        //Selection de l'identifiant de la reception
        $idReception = Reception::max('id');

        foreach ($lignes as $ligne){

            $detailReception = new DetailReception();
            $detailReception->receptions_id=$idReception;
            $detailReception->commandes_id = session('idCommande');
            $detailReception->articles_id = $ligne->articles_id;
            $detailReception->quantite = $request->input('quantiteLivree'.$ligne->id);
            $detailReception->prixUnitaire = $ligne->prixUnitaire;
            $detailReception->slug=$ligne->articles_id.$date->format('YmdHis');
            $detailReception->save();

            //Ajoute dans la table stock

            /*Si la l'article n'existe pas dans le stock on l'ajoute sinon on ajoute sa quantite */
            if (get_article_unique_in_stock($ligne->articles_id)==false){
                //creation dans le stock
                $stocks = new Stock();
                $stocks->articles_id = $ligne->articles_id;
                $stocks->quaniteStock = $request->input('quantiteLivree'.$ligne->id);
                $stocks->prixStock = $ligne->prixUnitaire;
                $stocks->save();
            }else{
                //on selectionne la ligne qui correspond a l'article dans le stock
                //pour pouvoir recuperer sa quantite et son prix afin de calculer le nouveau prix du stock
                $stk = Stock::where('articles_id', $ligne->articles_id)->first();
                //calcul de l'ancien prix de l'article en stock
                $valeurStock = $stk->quaniteStock * $stk->prixStock;

                //calcul du prix de l'article a ajouter
                $nouvelleValeur = $ligne->prixUnitaire * $request->input('quantiteLivree'.$ligne->id);

                //Calcul du nouveau prix de l'article dans le stock apres l'ajout
                $prixStock = ($valeurStock + $nouvelleValeur)/($stk->quaniteStock + $request->input('quantiteLivree'.$ligne->id));

                //modofocation dans le stock
                $stocks=stock::findOrFail(session('stockAmodifier'));
                $stocks->prixStock = round($prixStock, 0);
                $stocks->quaniteStock += $request->input('quantiteLivree'.$ligne->id);
                $stocks->save();
            }

            //Modification du dernier prix de l'article
            $articles = Article::findOrFail($ligne->articles_id);
            $articles->dernierPrix = $ligne->prixUnitaire;
            $articles->save();
        }

        return redirect()->route('reception.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailReception  $detailReception
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailReception  $detailReception
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
        $receptions = DetailReception::where('slug',$slug)->first();

        Session::put('articleAmodifier', $receptions->articles_id);
        Session::put('quantiteAmodifier', $receptions->quantite);

        return view('detailReceptions.edit', compact('articles', 'receptions', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailReception  $detailReception
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $date=new DateTime();//pour initialiser le slug dans la table stock
        //quantite maximale a ne pas depasser se trouvant dans articles
        $quantiteMaximum = Article::findOrFail($request->input('article'))->quantiteMaximum;

        //le stock a modifier
        $stockAmodifier = Stock::where('articles_id', $request->input('article'))->first();

        //la quantite dans le stock apres la dimunition de la quantite a modifier
        $quantiteStock = $stockAmodifier->quaniteStock - session('quantiteAmodifier');

        //quantite disponible apres la modification
        $nouvelleQuantite = $quantiteStock + $request->input('quantite');

        //si la nouvelle quantite est superieur a la nouvelle quantite on ramene un message d'alerte
        if($nouvelleQuantite > $quantiteMaximum){
            Session::flash('quantiteDepassee');
            return back();
        }

        if(session('articleAmodifier') == $request->input('article')){
            //on modifie la quantite dans le stock par la nouvelle quantite
            if(get_article_unique_in_stock($request->input('article')) == true){
                $stock = Stock::findOrFail(session('stockAmodifier'));
                $stock->quaniteStock = $nouvelleQuantite;
                $stock->save();
            }
        }else{//dans le cas ou l'article a ete modifier
            /*verifier si la quuantite maximale n'est pas depassee*/
            //quantite dans le stock
            $quantiteStock = $stockAmodifier->quaniteStock;

            //quantite disponible apres la modification
            $nouvelleQuantite = $quantiteStock + $request->input('quantite');
            //si la nouvelle quantite est superieur a la nouvelle quantite on ramene un message d'alerte
            if($nouvelleQuantite > $quantiteMaximum){
                Session::flash('quantiteDepassee');
                return back();
            }
            if(get_article_unique_in_stock(session('articleAmodifier'))){
                //modification du stock en dimuniant la quantite modifiee dans la fourniture qui a ete changee
                $stock = Stock::findOrFail(session('stockAmodifier'));
                $stock->quaniteStock -= session('quantiteAmodifier');
                $stock->save();
            }

            if(get_article_unique_in_stock($request->input('article')) == true){
                //si l'article existe dans le stock on augmente sa quantite
                $stock = Stock::findOrFail(session('stockAmodifier'));
                $stock->quaniteStock += $request->input('quantite');
                $stock->save();
            }else{
                //sinon on cree une nouvelle ligne
                $stocks=new Stock();
                $stocks->articles_id=$request->input('article');
                $stocks->quaniteStock = $request->input('quantite');
                $stocks->slug=$request->input('article').$date->format('YmdHis');
                $stocks->save();
            }
        }

        //enregistrement des modifications dans detail reception
        $reception = DetailReception::where('slug', $slug)->first();
        $reception->articles_id = $request->input('article');
        $reception->quantite = $request->input('quantite');
        $reception->prixUnitaire = $request->input('prixUnitaire');
        $reception->save();

        return redirect()->route('detailReception.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailReception  $detailReception
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        DetailReception::where('slug', $slug)->first()->delete();
        return back();
    }
}
