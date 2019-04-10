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
                        <div class="col col-lg-offset-10">
                            <a href="{{route('detailInventaire.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVEL INVENTAIRE</a>
                        </div>
                        <div class="panel-heading">
                            Liste des inventaire
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">CODE INVENTAIRE</th>
                                        <th class="text-center">DATE INVENTAIRE</th>
                                        <th class="text-center">UTILISATEUR</th>
                                        <th class="text-center">DETAILS</th>
                                        <th class="text-center">IMPRIMER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($inventaires as $detail)
                                        <tr>
                                            <td>{{$detail->codeInventaire}}</td>
                                            <td>{{$detail->dateInventaire}}</td>
                                            <td>{{$detail->nom}} {{$detail->prenom}} {{$detail->email}}</td>
                                            <td class="text-center">
                                                <a href="{{route('inventaire.show',$detail->id)}}" class="btn btn-info fa fa-list btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('detailInventaire.show',$detail->id)}}" class="btn btn-info fa fa-print btn-xl"></a>
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
