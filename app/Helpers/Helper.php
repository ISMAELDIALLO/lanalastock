<?php
use App\Demande;
use App\User;
use Illuminate\Support\Facades\DB;
use App\message;


//Une methode qui verifie l'existance d'un article dans le stock
if(!function_exists('get_article_unique_in_stock')){
    function get_article_unique_in_stock($article){
        $verifications= DB::table('stocks')
            ->where('articles_id','=',$article)
            ->select('*')
            ->get();
        if ($verifications->count()>0){
            $idstocks=0;
            foreach ($verifications as $verification){
                $idstocks=$verification->id;
            }

            //Si l'article existe on recupere l'identifiant du stock dans une variable de session pour pouvoir
            //modifier la quantite
            Session::put('stockAmodifier',$idstocks);
            return true;
        }
        return false;
    }
}
            //Une methode qui renvoi le nombre de demande non consulter
        if (!function_exists('compteur')){
        function compteur(){
                    $ligne = Demande::where('etat',0)->get();
                    $compteur=$ligne->count();
                    return $compteur;
            }
        }
        //Une methode qui permet de verifier si l'administrateur existe, elle est appélé lors du lancement de l'application
        if(!function_exists('admin')){
                    function admin(){
                        $admin=User::where('role',"administrateur");
                        if ($admin->count()>0){
                            return true;
                        }
                        return false;
                    }
        }
            //Une methode qui verifie si l'email du gestionnaire existe dans parametre
        if(!function_exists('mailgestionnaire')){
            function mailgestionnaire(){
                $gestionnaire=\App\Parametre::all();
                if ($gestionnaire->count()>0){
                    return true;
                }
                return false;
            }
        }

        //Cette fonction permet de verifier si l'utilisateur a l'autorisation de se connecter
        if(!function_exists('autorisation')){
            function autorisation($email){
                $users = User::whereEmail($email)->first();
                if ($users){
                    if ($users->statut == 1){
                        return 1;
                    }
                    return -1;
                }
                return 0;
            }
        }

        //Cette fonction permet de recuperer la liste des commandes non consultees i.e
        //Les commandes qui ont un etat egale a 0
        if(!function_exists('nonConsult')){
            function nonConsult(){
                $demandes=DB::table('users')
                    ->join('demandes', 'users.id', '=', 'demandes.users_id')
                    ->where('demandes.etat', 0)
                    ->select('users.nom', 'users.prenom', 'users.email', 'demandes.*')
                    ->get();

                return $demandes;
            }
        }

        //Cette fonction permet de recuperer chaque utilisateur avec les sous-menus qu'il peut voir
        if(!function_exists('habilitation')){
            function habilitation(){
                $habilitations=DB::table('users')
                    ->join('services', 'services.id', '=', 'users.services_id')
                    ->join('abilitations', 'users.id', '=', 'abilitations.users_id')
                    ->join('sous_menus', 'abilitations.sous_menu_id', '=', 'sous_menus.id')
                    //->join('menus', 'sous_menus.menus_id', '=', 'menus.id')
                    ->where('abilitations.users_id', '=', auth()->user()->id)
                    ->select('sous_menus.*')
                    ->get();

                    return $habilitations;
            }
        }

        //cette fonction retourne l'ensemble des menus (de maniere distinct) auxquels l'utilisateur connecté a acces à au moins
        //un sous menu
        if(!function_exists('menu')){
            function menu(){
                $menus = DB::table('menus')
                    ->join('sous_menus', 'menus.id', '=', 'sous_menus.menus_id')
                    ->join('abilitations', 'sous_menus.id', '=', 'abilitations.sous_menu_id')
                    ->where('abilitations.users_id', '=', auth()->user()->id)
                    ->distinct()
                    ->select('menus.*')
                    ->get();

                return $menus;
            }
        }

        //Cette fonction permet de verifier si un message existe
        if(!function_exists('message')){
            function message(){
                $messages = message::all();
                if ($messages->count()>0){
                    return true;
                }
                return false;
            }
        }

        //Cette fonction permet de verifier si le mail du gestionnaire existe
        if(!function_exists('gestionnaire')){
            function gestionnaire(){
                $gestionnaire = \App\Parametre::all();
                if ($gestionnaire->count()>0){
                    return true;
                }
                return false;
            }
        }
