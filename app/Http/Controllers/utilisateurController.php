<?php

namespace App\Http\Controllers;

use App\Http\Requests\utilisateurFormRequest;
use App\Role;
use App\Service;
use App\User;
use App\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use DateTime;
use MercurySeries\Flashy\Flashy;

class utilisateurController extends Controller
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

        if(auth()->user()->role == "administrateur"){
            $demandes = nonConsult();

            $users =DB::table('services')
            ->join('users','users.services_id','=','services.id')
            ->join('societes','societes.id','=','services.societes_id')
                ->select('services.service','societes.nomSociete','users.*')->get();
            return view('utilisateurs.liste', compact('users', 'demandes'));
        }else{
            return back();
        }
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

        $roles = Role::all();
        $societe_services=DB::table('societes')
                  ->join('services','societes.id','=','services.societes_id')
                  ->select('services.*','societes.nomSociete')
                  ->get();
        return view('utilisateurs.ajouter',compact('societe_services', 'demandes', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(utilisateurFormRequest $request)
    {
       $date=new DateTime();
        //dd('user');
        $mdp1=$request->input('password');
        $mdp2=$request->input('password_confirmation');
        if ($mdp1!=$mdp2){
            Session::put('errorMotDePasse');
        }
        $utilisateurs = new User();
        $utilisateurs->nom = $request->input('name');
        $utilisateurs->prenom = $request->input('prenom');
        $utilisateurs->email = $request->input('email');
        $utilisateurs->nomSuperieur = $request->input('nomSuperieur');
        $utilisateurs->emailSuperieur = $request->input('emailSuperieur');
        $utilisateurs->services_id = $request->input('service');
        $utilisateurs->role = $request->input('role');
        $utilisateurs->password = Hash::make($request->input('password'));
        $utilisateurs->confirm_mot_de_passe = Hash::make($request->input('password_confirmation'));
        $utilisateurs->slug = $request->input('name').$date->format('YmHis');
        $utilisateurs->statut=1;
        $utilisateurs->save();
        Flashy::success('Utilisateur enregistrer avec succes');
        return redirect()->route('utilisateur.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //la fonction est utilisée pour débloquer ou bloquer un utilisateur
        $user = User::whereSlug($slug)->first();
        if ($user->statut==0){
            $user->statut = 1;
            $user->save();
        }else{
            $user->statut = 0;
            $user->save();
        }
        return redirect()->route('utilisateur.index');
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

        $services=DB::table('societes')
            ->join('services','societes.id','=','services.societes_id')
            ->select('services.*','societes.nomSociete')
            ->get();

        $roles = Role::all();
        $users = User::where('slug',$slug)->first();
        return view('utilisateurs.modif', compact('services','users','demandes','roles'));
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
        $users = User::where('slug',$slug)->first();

        $users->nom = $request->input('name');
        $users->prenom = $request->input('prenom');
        $users->email = $request->input('email');
        $users->nomSuperieur = $request->input('nomSuperieur');
        $users->emailSuperieur = $request->input('emailSuperieur');
        $users->role = $request->input('role');
        $users->services_id=$request->input('service');
        $users->save();
        return redirect()->route('utilisateur.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {

    }


}
