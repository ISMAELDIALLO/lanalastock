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
                            Liste des sorties dans le stock
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>CODE</th>
                                        <th>DATE SORTIE</th>
                                        <th>EFFECTUEE PAR</th>
                                        <th>DETAILS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sorties as $sortie)
                                        <tr>
                                            <td>{{$sortie->codeSortie}}</td>
                                            <td>{{$sortie->dateSortie}}</td>
                                            <td>{{$sortie->nom}} {{$sortie->prenom}} {{$sortie->email}}</td>
                                            <td>
                                                <a href="{{route('detailSortieStock.show', $sortie->id)}}" class="btn btn-info fa fa-list"></a>
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