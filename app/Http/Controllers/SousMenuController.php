<?php

namespace App\Http\Controllers;

use App\Menu;
use App\SousMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Session;
use MercurySeries\Flashy\Flashy;

class SousMenuController extends Controller
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

        $sousMenus = DB::table('menus')
            ->join('sous_menus', 'menus.id', '=', 'sous_menus.menus_id')
            ->select('menus.nomMenu', 'sous_menus.*')
            ->get();

        return view('sousMenus.liste',compact('sousMenus','demandes'));
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

        $menus = Menu::all();

        return view('sousMenus.ajout', compact('menus', 'demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sousMenu = SousMenu::where('nomSousMenu',$request->input('nomSousMenu'))->first();
        $lien = SousMenu::where('lien',$request->input('lien'))->first();
        if ($sousMenu || $lien){
            Session::flash('warning');
            return back();
        }
        $date = new DateTime();
        $sousMenu = new SousMenu();
        $sousMenu->menus_id = $request->input('menu');
        $sousMenu->nomSousMenu = $request->input('nomSousMenu');
        $sousMenu->lien = $request->input('lien');
        $sousMenu->slug = $request->input('lien'). $date->format('YmdHis');
        $sousMenu->save();

        return redirect()->route('sousMenu.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SousMenu  $sousMenu
     * @return \Illuminate\Http\Response
     */
    public function show(SousMenu $sousMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SousMenu  $sousMenu
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page
        $demandes= nonConsult();

        $menus = Menu::all();

        $sousMenus = SousMenu::whereSlug($slug)->first();

        return view('sousMenus.modif', compact('sousMenus', 'demandes','menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SousMenu  $sousMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $sousMenu = SousMenu::where('nomSousMenu',$request->input('nomSousMenu'))->first();
        //$lien = SousMenu::where('lien',$request->input('lien'))->first();
        if ($sousMenu){
                if ($sousMenu->slug != $slug){
                    Session::flash('warning');
                    return back();
            }
        }
        $sousMenu = SousMenu::whereSlug($slug)->first();
        $sousMenu->menus_id = $request->input('menu');
        $sousMenu->nomSousMenu = $request->input('nomSousMenu');
        $sousMenu->lien = $request->input('lien');
        $sousMenu->save();

        return redirect()->route('sousMenu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SousMenu  $sousMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $sousMenu=SousMenu::where('slug',$slug)->first();
        $sousMenu->delete();
        Flashy::error('Suppression effectue avec succes');
         return redirect()->route('sousMenu.index');
    }
}
