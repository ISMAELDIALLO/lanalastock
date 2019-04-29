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
                <div class="col-lg-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="col-md-offset-11">
                            <a href="{{route('sortieStock.index')}}" class="btn btn-info glyphicon glyphicon-arrow-left"></a>
                        </div>

                        <div class="panel-heading">
                            Details de la sortie : {{$codeSortie}}
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>ARTICLE</th>
                                        <th>QUANTITE SORTANTE</th>
                                        <th>QUANTITE DEMANDE</th>
                                        <th>PRIX</th>
                                        <th>MOTIF</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($details as $detail)
                                        <tr>
                                            <td>{{$detail->libelleArticle}}</td>
                                            <td>{{$detail->quantiteSortante}}</td>
                                            <td>{{$detail->quantiteDemandee}}</td>
                                            <td>{{$detail->prix}}</td>
                                            <td>{{$detail->motif}}</td>
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
