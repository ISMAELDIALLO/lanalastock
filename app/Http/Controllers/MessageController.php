<?php

namespace App\Http\Controllers;

use App\message;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Session;

class MessageController extends Controller
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

        $messages = message::all();
        return view('messages.list',compact('messages','demandes'));
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
        return view('messages.ajout',compact('demandes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //$messages = message::all();
           $date = new DateTime();
           $messages = new message();
           $messages->messageGestionnaire = $request->input('messageGestionnaire');
           $messages->messageSuperieur = $request->input('messageSuperieur');
           $messages->slug = $request->input('messageGestionnaire').$date->format('YmHis');
           $messages->save();
           return redirect()->route('message.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $messages = message::whereSlug($slug)->first();

        return view('messages.modif', compact('demandes', 'messages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $messages = message::whereSlug($slug)->first();

        $messages->messageGestionnaire = $request->input('messageGestionnaire');
        $messages->messageSuperieur = $request->input('messageSuperieur');
        $messages->save();
        return redirect()->route('message.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $messages = message::whereSlug('slug',$slug)->first();
        $messages->delete();
        return redirect()->route('message.index');
    }
}
