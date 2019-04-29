<?php

namespace App\Http\Controllers;

use App\Http\Requests\serviceFormResquest;
use App\Service;
use App\Societe;
use App\SocieteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use MercurySeries\Flashy\Flashy;

class ServiceController extends Controller
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

        $services=DB::table('societes')
            ->join('services', 'services.societes_id', '=', 'societes.id')
            ->select('societes.nomSociete', 'services.*')
            ->get();
        return view('services.list',compact('services', 'demandes'));
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

        $societes = Societe::all();

        return view('services.ajouter', compact('demandes', 'societes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(serviceFormResquest $request)
    {
        $societes = Societe::all();
        //dd($societes);
        //La
        /*$nomS = "";
        foreach ($societes as $societe){
            if ($request->input($societe->nomSociete)){
                $nomS = $request->input($societe->nomSociete);
                $serv = Service::where('service',$request->input('service'))->first();
                if ($serv){
                     $ids = $serv->id;
                    $verification = SocieteService::where([
                        'societes_id' => $request->input($societe->nomSociete),
                        'services_id' => $ids,
                    ])->first();

                    if ($verification){
                        Session::flash('serviceExiste');
                        return back();
                    }
                }

            }
        }

        if (!$nomS){
            Flashy::error('Veuillez selectionner au moins une societe');
            return back();
        }
        */

        $date=new DateTime();
        $servs=Service::select(DB::raw("CONCAT('CS0', MAX(CAST(RIGHT(codeService,LENGTH(codeService)-3) AS UNSIGNED))+1) AS code"))
            ->get();
        $ser="CS01";
        foreach ($servs as $serv){
            if ($serv->code){
                $ser=$serv->code;
            }
        }

        $societe = Societe::findOrFail($request->input('societe'));
        if ($societe){
            $verification = Service::where([
                'societes_id' => $request->input('societe'),
                'service'=> $request->input('service'),
            ])->first();

            if ($verification){
                Session::flash('serviceExiste');
                return back();
            }
        }

        $service = new Service();
        $service->codeService=$ser;
        $service->service=$request->input('service');
        $service->societes_id = $request->input('societe');
        $service->slug=$ser.$date->format('YmdHis');
        $service->save();

       /* $idService = Service::max('id');

        foreach ($societes as $societe){
            if ($request->input($societe->nomSociete)){
                $societeService = new SocieteService();
                $societeService->societes_id = $request->input($societe->nomSociete);
                $societeService->services_id = $idService;
                $societeService->save();
            }
        }*/

        Flashy::success('Service enregistrer avec succes');
        return redirect()->route('service.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //nonConsult() est une methode helper qui retourne l'ensemble des comandes non consultees
        //$demandes est utilisee a la page d'accueil apres l'authentification
        //donc necessaires pour toutes les fonction qui utilse cette page

        $demandes = nonConsult();

        $societes = Societe::all();

        $service=Service::whereSlug($slug)->first();
        return view('services.edit',compact('service', 'societes', 'demandes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(serviceFormResquest $request, $slug)
    {
        $verification = SocieteService::where([
            'societes_id' => $request->input('societe'),
            'service' => $request->input('service')
        ])->first();

        if ($verification){
            if ($verification->slug != $slug){
                Session::flash('serviceExiste');
                return back();
            }
        }

        $service=Service::whereSlug($slug);
        $service->update([
            'service'=>request('service'),
            'pourcentage'=>request('pourcentage'),
            'pourcentage_vie'=>request('pourcentage_vie')
        ]);
        Flashy::success('Service modifier avec succes');
        return redirect()->route('service.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $service=Service::whereSlug($slug)-> first();
        $service->delete();

        Flashy::success('Service supprime avec succes');
        return redirect()->route('service.index');
    }
}
