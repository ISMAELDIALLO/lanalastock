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

                        <div class="panel-heading">
                            Liste des demandes
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">CODE DEMANDE</th>
                                        <th class="text-center">DATE DEMANDE</th>
                                        <th class="text-center">UTILISATEUR</th>
                                        <th class="text-center">MAIL SUPERIEUR</th>
                                        <th class="text-center">DETAILS</th>
                                        <th class="text-center">VALIDER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($listdemandes as $demande)
                                        <tr>
                                            <td>{{$demande->codeDemande}}</td>
                                            <td>{{$demande->dateDemande}}</td>
                                            <td>{{$demande->nom}} {{$demande->prenom}} {{$demande->email}}</td>
                                            <td>{{$demande->emailSuperieur}}</td>
                                            <td>
                                                <a href="{{route('detailDemande.show',$demande->id)}}" class="btn btn-info fa fa-list"></a>
                                            </td>
                                            <td class="text-center">
                                                @if($demande->statut != 1)
                                                <a href="{{route('demande.show',$demande->id)}}" class="btn btn-info fa fa-check"></a>
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