@extends('index')
@section('content')
    <div id="wrapper">

        <!-- Navigation -->


        <div id="page-wrapper">
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
                            <h2>Le stock</h2>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>ARTICLE</th>
                                        <th>QUANTITE DISPONIBLE</th>
                                        <th>QUANTITE MINIMUMALE</th>
                                        <th>QUANTITE MAXIMUMALE</th>
                                        <th>PRIX STOCK</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stocks as $stock)
                                            @if($stock->quantiteMinimum >= $stock->quaniteStock)
                                                <tr class="alert alert-danger">
                                                    <td class="alert alert-danger">{{$stock->libelleArticle}}</td>
                                                    <td class="alert alert-danger">{{$stock->quaniteStock}}</td>
                                                    <td class="alert alert-danger">{{$stock->quantiteMinimum}}</td>
                                                    <td class="alert alert-danger">{{$stock->quantiteMaximum}}</td>
                                                    <td class="alert alert-danger">{{$stock->prixStock}}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{$stock->libelleArticle}}</td>
                                                    <td>{{$stock->quaniteStock}}</td>
                                                    <td>{{$stock->quantiteMinimum}}</td>
                                                    <td>{{$stock->quantiteMaximum}}</td>
                                                    <td>{{$stock->prixStock}}</td>
                                                </tr>
                                            @endif
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
