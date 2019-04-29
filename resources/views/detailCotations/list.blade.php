@extends('index')
@section('content')
    <div id="wrapper">

        <!-- Navigation -->


        <div id="page-wrapper">
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
                            Liste des cotations
                            <a href="{{route('detailCotation.create')}}" class="col-md-offset-8">Creer une cotation</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">CODE COTATION</th>
                                        <th class="text-center">DATE COTATION</th>
                                        <th class="text-center">UTILISATEUR</th>
                                        <th class="text-center">DETAILS</th>
                                        <th class="text-center">IMPRIMER</th>
                                        <th class="text-center">BON DE COMMANDE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($listCotations as $cotation)
                                        <tr>
                                            <td>{{$cotation->codeCotation}}</td>
                                            <td>{{$cotation->dateCotation}}</td>
                                            <td>{{$cotation->nom}} {{$cotation->prenom}}</td>
                                            <td>
                                                <a href="{{route('detailCotation.show',$cotation->id)}}" class="btn btn-info fa fa-list"></a>
                                            </td>
                                            <td class="text-center">
                                                    <a href="{{route('cotation.show',$cotation->id)}}" class="btn btn-info fa fa-print"></a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('bonDeCommande',$cotation->id)}}" class="btn btn-info glyphicon glyphicon-ok"></a>
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
