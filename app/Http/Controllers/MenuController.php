<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
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

        $menus = Menu::all();
        return view('menus.list',compact('menus','demandes'));
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
        return view('menus.ajout',compact('demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = Menu::where('nomMenu',$request->input('nomMenu'))->first();
        if ($menu){
            Session::flash('warning');
            return back();
        }
        $date = new DateTime();
        $menu = new Menu();
        $menu->nomMenu = $request->input('nomMenu');
        $menu->slug = $request->input('nomMenu').$date->format('YmdHis');
        $menu->save();

        return redirect()->route('menu.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page
        $demandes= nonConsult();

        $menu = Menu::where('slug',$slug)->first();
        return view('menus.modif',compact('menu','demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
         $menu = Menu::where('nomMenu',$request->input('nomMenu'))->first();
         if ($menu){
             if ($menu->slug != $slug){
                 Session::flash('warning');
                 return back();
             }
         }
        $date = new DateTime();
        $menu = Menu::where('slug',$slug)->first();
        $menu->nomMenu = $request->input('nomMenu');
        $menu->slug = $request->input('nomMenu').$date->format('YmdHis');
        $menu->save();

        return redirect()->route('menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
