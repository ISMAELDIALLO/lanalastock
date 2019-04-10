@extends('index')
@section('content')
    <div id="wrapper">

        <!-- Navigation -->


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tableau</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
                <div class="container col-md-12">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{session()->get('message')}}
                        </div>
                    @endif

                </div>
                <div class="container col-md-12">
                    @if(session()->has('message1'))
                        <div class="alert alert-danger">
                            {{session()->get('message1')}}
                        </div>
                    @endif

                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="col col-lg-offset-9">
                            <a href="{{route('utilisateur.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVEAU UTILISATEUR</a>
                        </div>
                        <div class="panel-heading">
                            Liste des Utilisateurs
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered text-center table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>NOM & PRENOM</th>
                                        <th>EMAIL</th>
                                        <th>EMAIL DU SUPERIEUR</th>
                                        <th>ROLE</th>
                                        <th>SERVICE</th>
                                        <th>ETAT</th>
                                        <th>MODIFIER</th>
                                        <th>BLOQUER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$user->nom}} {{$user->prenom}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->emailSuperieur}}</td>
                                            <td>{{$user->role}}</td>
                                            <td>{{$user->service}} - {{$user->nomSociete}}</td>
                                            <td>
                                                @if($user->statut == 1)
                                                    {{"En fonction"}}
                                                @else
                                                    {{"Bloqué"}}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('utilisateur.edit',$user->slug)}}" class="btn btn-info fa fa-pencil-square-o btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                @if($user->statut == 1)
                                                    <a href="{{route('utilisateur.show',$user->slug)}}" class="btn btn-warning fa fa-lock btn-xl"></a>
                                                @else
                                                    <a href="{{route('utilisateur.show',$user->slug)}}" class="btn btn-success fa fa-unlock btn-xl"></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </section>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /#wrapper -->
    </div>
@endsection
