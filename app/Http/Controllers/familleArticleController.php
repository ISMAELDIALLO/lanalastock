<?php

namespace App\Http\Controllers;

use App\familleArticle;
use App\Http\Requests\familleArticleFormResquest;
use App\SuperCategorieArticle;
use \DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use MercurySeries\Flashy\Flashy;

class familleArticleController extends Controller
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

        $familles=DB::table('super_categorie_articles')
            ->join('famille_articles','famille_articles.super_categories_id','=','super_categorie_articles.id')
            ->select('super_categorie_articles.superCategorie','famille_articles.*')
            ->get();

        return view('familleArticles.list',compact('familles', 'demandes'));
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

        $categories = SuperCategorieArticle::all();

        return view('familleArticles.create', compact('demandes', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(familleArticleFormResquest $request)
    {

        //Avant tout d'abord on verifie si la famille d'article n'existe pas dans la table avant d'inserer
        //Si elle existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $article = FamilleArticle::where('libelleFamilleArticle',$request->input('famille'))->first();
        if ($article){
            Session::flash('warning');
            return back();
        }

        $codes=FamilleArticle::select(DB::raw("CONCAT('FA0', MAX(CAST(RIGHT(codeFamilleArticle,LENGTH(codeFamilleArticle)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $co="FA01";
        foreach ($codes as $code){
            if ($code->code){
                $co=$code->code;
            }
        }
        $date = new DateTime();
         //$date->format('YmdHis');
        $familleArticles=new familleArticle();
        //dd(max($familleArticles('')))
        $familleArticles->libelleFamilleArticle=$request->input('famille');
        $familleArticles->codeFamilleArticle=$co;
        $familleArticles->super_categories_id = $request->input('categorie');
        $familleArticles->typeImputation = $request->input('typeImputation');
        $familleArticles->slug=$request->input('famille').$date->format('YmdHis');
        $familleArticles->save();

        Flashy::success('famille ajoutee avec succes');
        return redirect()->route('familleArticle.index');
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

        $demandes = nonConsult();

        $categories = SuperCategorieArticle::all();

        //$produit = Produit::where('Slug',$slug)->first();
       $familles=FamilleArticle::where('Slug',$slug)->first();
       // dd($familles);
        return view('familleArticles.edit',compact('familles', 'demandes', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(familleArticleFormResquest $request, $slug)
    {
        //Avant tout d'abord on verifie si la famille de l'article n'existe pas dans la table avant de valider les modifications
        //S'il existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $famille = FamilleArticle::where('libelleFamilleArticle',$request->input('famille'))->first();
        if ($famille){
            //On verifie si la ligne trouvee est differente de celle qu'on est entrain de modifier
            //Si c'est le cas on empeche la modification tout en ramenant un message d'erreur
            //Si c'est la meme ligne on valide les modifications
            if ($famille->slug != $slug){
                Session::flash('warning');
                return back();
            }
        }

        $familles=FamilleArticle::where('Slug',$slug)->first();
        $familles->super_categories_id = $request->input('categorie');
        $familles->typeImputation = $request->input('typeImputation');
        $familles->libelleFamilleArticle=$request->input('famille');
        $familles->save();

        Flashy::success('famille modifiee avec succes');

        return redirect()->route('familleArticle.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $familles=FamilleArticle::where('slug', $slug)->first();
        $familles->delete();
        Flashy::success('famille supprimee avec succes');
        return redirect()->route('familleArticle.index');
    }
}
