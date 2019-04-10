<?php

namespace App\Http\Controllers;

use App\Abilitation;
use App\Menu;
use App\SousMenu;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MercurySeries\Flashy\Flashy;
use Illuminate\Support\Facades\Session;

class AbilitationController extends Controller
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
        $habilitations = DB::table('users')
                ->join('abilitations','users.id','=','abilitations.users_id')
                ->join('sous_menus','sous_menus.id','=','abilitations.sous_menu_id')
                ->select('sous_menus.nomSousMenu','users.nom','users.prenom','users.email','abilitations.*')
                ->get();
        return view('abilitations.list',compact('demandes','habilitations'));
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
        $demandes= nonConsult();

        $users = User::all();
        $menus = Menu::all();
        $sousMenus = SousMenu::all();

         return view('abilitations.ajout',compact('demandes','sousMenus','users', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $sousMenus = SousMenu::all();
        $nomSousMenu = "";
        foreach ($sousMenus as $sousMenu) {
            if ($request->input($sousMenu->id)){
                $nomSousMenu = $request->input($sousMenu->id);
                $users = User::where('id',$request->input('utilisateur'))->first();
                if ($users){
                    $idU = $users->id;
                    $verif = Abilitation::where([
                        'sous_menu_id' =>$request->input($sousMenu->id),
                        'users_id' =>$idU,
                    ])->first();
                    if ($verif){
                        Session::flash('doublons');
                        return back();
                    }
                }
            }
        }
        if (!$nomSousMenu){
            Flashy::error('Veuillez selectionner un sous menu');
            return back();
        }

        foreach ($sousMenus as $sousMenu) {
            if ($request->input($sousMenu->id)){
                $nomSousMenu = $request->input($sousMenu->id);
                $abilitations = new Abilitation();
                $abilitations->users_id = $request->input('utilisateur');
                $abilitations->sous_menu_id = $nomSousMenu;
                $abilitations->save();
            }
        }

        return redirect()->route('abilitation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Abilitation  $abilitation
     * @return \Illuminate\Http\Response
     */
    public function show(Abilitation $abilitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Abilitation  $abilitation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page
        $demandes= nonConsult();

        $users = User::all();

        $sousMenus = SousMenu::all();

        $habilitations = Abilitation::findOrFail($id);


        return view('abilitations.modif',compact('demandes','users','sousMenus','habilitations'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Abilitation  $abilitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $sousMenus = SousMenu::all();

        $verifie = Abilitation::where([
           'users_id'=>$request->input('utilisateur'),
            'sous_menu_id'=>$request->input('sousMenu')
        ])->first();
        if ($verifie){
            if ($verifie->id != $id){
                    Session::flash('doublons');
                    return back();
            }
        }
        $abilitations = Abilitation::findOrFail($id);
        $abilitations->users_id = $request->input('utilisateur');
        $abilitations->sous_menu_id = $request->input('sousMenu');
        $abilitations->save();
        return redirect()->route('abilitation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Abilitation  $abilitation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $abilitations = Abilitation::findOrFail($id);
        $abilitations->delete();
        Flashy::error('Suppression effectuez avec succes');
        return redirect()->route('abilitation.index');
    }
}
