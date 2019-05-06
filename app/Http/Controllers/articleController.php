<?php

namespace App\Http\Controllers;

use App\Article;
use App\FamilleArticle;
use App\HistoriqueArticle;
use App\Http\Requests\articleFormResquest;
use Illuminate\Http\Request;
use \DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Excel;
use MercurySeries\Flashy\Flashy;

class articleController extends Controller
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
        $demandes= nonConsult();
        $articles=DB::table('super_categorie_articles')
            ->join('famille_articles', 'super_categorie_articles.id', '=', 'famille_articles.super_categories_id')
            ->join('articles','famille_articles.id','=','articles.famille_articles_id')
            ->where('articles.type', '=', 1)
            ->select('famille_articles.libelleFamilleArticle','articles.*')
            ->get();
        return view('articles.list',compact('articles', 'demandes'));
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
        $familles = DB::table('super_categorie_articles')
            ->join('famille_articles', 'super_categorie_articles.id', '=', 'famille_articles.super_categories_id')
            ->select('super_categorie_articles.superCategorie', 'famille_articles.*')
            ->get();

        return view('articles.create',compact('familles', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(articleFormResquest $request)
    {
        //Avant tout d'abord on verifie si l'article n'existe pas dans la table avant d'inserer
        //S'il existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $article = Article::where('libelleArticle',$request->input('libelle'))->first();
        if ($article){
            Session::flash('warning');
            return back();
        }


        $date = new DateTime();
        $articles=new Article();
        //Generation automatique de la réference de  l'article.
        $refs=Article::select(DB::raw("CONCAT('AR0', MAX(CAST(RIGHT(referenceArticle,LENGTH(referenceArticle)-3) AS UNSIGNED))+1) AS reference"))
            ->get();
        $re="AR01";
        foreach ($refs as $ref){
            if ($ref->reference){
                $re=$ref->reference;
            }
        }

        $articles->famille_articles_id=$request->input('famille');
        $articles->referenceArticle=$re;
        $articles->libelleArticle=$request->input('libelle');
        $articles->quantiteminimum=$request->input('quantiteminimum');
        $articles->quantitemaximum=$request->input('quantitemaximum');
        $articles->dernierPrix=$request->input('dernierPrix');
        $articles->type = 1;
        $articles->slug=$request->input('libelle').$date->format('YmdHis');
        $articles->save();

        Flashy::success('Article ajouter avec succes');
        return redirect()->route('article.index');
    }

    public function exportFile(){
        return view('articles.export');
    }

    public function downloadExcel(){
        $data = Article::get()->toArray();
        return Excel::create('itsolutionstuff',function ($excel) use ($data)
        {
            $excel->sheet('mySheet',function ($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->downdload();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        $demandes= nonConsult();

        $familles = DB::table('super_categorie_articles')
            ->join('famille_articles', 'super_categorie_articles.id', '=', 'famille_articles.super_categories_id')
            ->select('super_categorie_articles.superCategorie', 'famille_articles.*')
            ->get();

        $articles = Article::where('slug', $slug)->first();

        return view('articles.edit', compact('familles', 'articles', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(articleFormResquest $request, $slug)
    {
        //Avant tout d'abord on verifie si l'article n'existe pas dans la table avant de valider les modifications
        //S'il existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $article = Article::where('libelleArticle',$request->input('libelle'))->first();
        if ($article){
            //On verifie si la ligne trouvee est differente de celle qu'on est entrain de modifier
            //Si c'est le cas on empeche la modification tout en ramenant un message d'erreur
            //Si c'est la meme ligne on valide les modifications
            if ($article->slug != $slug){
                Session::flash('warning');
                return back();
            }
        }

        $articleAncien = Article::whereSlug($slug)->first();

        if (($articleAncien->dateDebutContrat != $request->input('dateDebutContrat')) || ($articleAncien->dateFinContrat != $request->input('dateFinContrat')) || ($articleAncien->dernierPrix != $request->input('dernierPrix'))){
            //on insere dans la table historique
            $historique = new HistoriqueArticle();
            if ($request->input('libelle')){
                $historique->article=$request->input('libelle');
            }
            if ($request->input('dateDebutContrat')){
                $historique->dateDebutContrat=$request->input('dateDebutContrat');
            }
            if ($request->input('dateFinContrat')){
                $historique->dateFinContrat=$request->input('dateFinContrat');
            }
            if ($request->input('dernierPrix')){
                $historique->prixUnitaire=$request->input('dernierPrix');
            }
            $historique->save();
        }


        $articles = Article::where('slug', $slug)->first();
        $articles->famille_articles_id=$request->input('famille');
        $articles->libelleArticle=$request->input('libelle');
        $articles->quantiteminimum=$request->input('quantiteminimum');
        $articles->quantitemaximum=$request->input('quantitemaximum');
        $articles->dernierPrix=$request->input('dernierPrix');
        if ($request->input('periodicitePayement')){
            $articles->periodicitePayement=$request->input('periodicitePayement');
        }
        if ($request->input('dateDebutContrat')){
            $articles->dateDebutContrat=$request->input('dateDebutContrat');
        }
        if ($request->input('dateFinContrat')){
            $articles->dateFinContrat=$request->input('dateFinContrat');
        }
        $articles->save();



        Flashy::success('modification effectue avec succes');
        return redirect()->route('article.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $articles=Article::where('slug', $slug)->first();
        $articles->delete();
        Flashy::error('famille supprimee avec succes');
        return redirect()->route('article.index');
    }
}
