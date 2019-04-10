<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function logout(Request $request)
    {
       //deconnexion automatique
        // On remplit le cookie par une valeur fausse pour ne pas être réutilisé
//        setcookie("sid", "session ended", time()+60);
//
//        // Invalidation de l'objet $_SESSION
//        session_unset();
//
//        // Destruction de l'objet $_SESSION
//        session_destroy();

        Auth::logout();

        // On redirige l'utilisateur vers la page d'accueil
        /*$this->guard()->logout();

        $request->session()->invalidate();*/

        return redirect('/login');
    }
}
