<?php

namespace App\Http\Controllers;

use App\Article;
use App\DetailReception;
use App\Fournisseur;
use App\Reception;
use App\Stock;
use App\TemporaireReception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Session;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date=new DateTime();
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
        $receptions->fournisseurs_id=$request->input('fournisseur');
        $receptions->codeReception=$rc;
        $receptions->dateReception=$request->input('dateReception');
        $receptions->slug=$request->input('dateReception').$date->format('YmdHis');
        $receptions->save();

        //Selection de l'identifiant de la reception
        $idReception=Reception::max('id');
        /*Insertion dans ligne de reception, tanque ya d'enregistrement dans la table temporaire on insert dans la table
         ligne de reception et à chque fois on un nouvel objet et apres insertion on supprime les données dans la table temporaire
        */
        $temporaires=TemporaireReception::all();
        foreach ($temporaires as $temporaire){
            $detailReception = new DetailReception();
            $detailReception->receptions_id=$idReception;
            $detailReception->articles_id=$temporaire->articles;
            $detailReception->quantite=$temporaire->quantite;
            $detailReception->prixUnitaire=$temporaire->prixUnitaire;
            $detailReception->slug=$rc.$date->format('YmdHis');
            $detailReception->save();

            //Ajoute dans la table stock

            /*Si la l'article n'existe pas dans le stock on l'ajoute sinon on ajoute sa quantite */
            if (get_article_unique_in_stock($temporaire->articles)==false){
                //creation dans le stock
                $stocks=new Stock();
                $stocks->articles_id = $temporaire->articles;
                $stocks->quaniteStock = $temporaire->quantite;
                $stocks->prixStock = $temporaire->prixUnitaire;
                $stocks->save();
            }else{
                //on selectionne la ligne qui correspond a l'article dans le stock
                //pour pouvoir recuperer sa quantite et son prix afin de calculer le nouveau prix du stock
                $stk = Stock::where('articles_id', $temporaire->articles)->first();
                //calcul de l'ancien prix de l'article en stock
                $valeurStock = $stk->quaniteStock * $stk->prixStock;

                //calcul du prix de l'article a ajouter
                $nouvelleValeur = $temporaire->prixUnitaire * $temporaire->quantite;

                //Calcul du nouveau prix de l'article dans le stock apres l'ajout
                $prixStock = ($valeurStock + $nouvelleValeur)/($stk->quaniteStock + $temporaire->quantite);

                //modofocation dans le stock
                $stocks=stock::findOrFail(session('stockAmodifier'));
                $stocks->prixStock = round($prixStock, 2);
                $stocks->quaniteStock+=$temporaire->quantite;
                $stocks->save();
            }

            //Modification du dernier prix de l'article
            $articles = Article::findOrFail($temporaire->articles);
            $articles->dernierPrix = $temporaire->prixUnitaire;
            $articles->save();
        }
        //Vider la table temporaire
        TemporaireReception::truncate();
        return redirect()->route('reception.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailReception  $detailReception
     * @return \Illuminate\Http\Response
     */
    public function show(DetailReception $detailReception)
    {
        //
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
