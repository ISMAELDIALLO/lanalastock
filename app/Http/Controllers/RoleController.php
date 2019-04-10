<?php

namespace App\Http\Controllers;

use App\Http\Requests\roleFormRequest;
use App\Role;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
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

        $roles = Role::all();

        return view('roles.list',compact('demandes','roles'));
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

        return view('roles.ajout',compact('demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(roleFormRequest $request)
    {
        //Avant tout d'abord on verifie si le role n'existe pas dans la table avant d'inserer
        //Si elle existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $role = Role::where('role',$request->input('role'))->first();
        if ($role){
            Session::flash('warning');
            return back();
        }

        $date = new DateTime();

        $roles = new Role();

        $roles->role = $request->input('role');

        $roles->slug =$date->format('YmHis');
        $roles->save();
        return redirect()->route('role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $roles = Role::whereSlug($slug)->first();

        return view('roles.edit',compact('demandes','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(roleFormRequest $request, $slug)
    {
        //Avant tout d'abord on verifie si le role  n'existe pas dans la table avant de valider les modifications
        //S'il existe on ramene un message d'erreur
        //Dans le cas contraire on passe pour l'insertion
        $role = Role::where('role',$request->input('role'))->first();
        if ($role){
            //On verifie si la ligne trouvee est differente de celle qu'on est entrain de modifier
            //Si c'est le cas on empeche la modification tout en ramenant un message d'erreur
            //Si c'est la meme ligne on valide les modifications
            if ($role->slug != $slug){
                Session::flash('warning');
                return back();
            }
        }

        $roles = Role::whereSlug($slug)->first();

        $roles->role = $request->input('role');

        $roles->save();

        return redirect()->route('role.index', compact('roles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $roles = Role::whereSlug($slug)->first();

        $roles->delete();

        return redirect()->route('role.index');
    }
}
