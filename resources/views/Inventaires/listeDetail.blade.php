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
                <div class="col-lg-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="col-md-offset-7">
                            <a href="{{route('inventaire.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
                        </div>
                        <div class="panel-heading">
                            Details de l'inventaire : {{$codeInventaire}}
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>ARTICLE</th>
                                        <th>QUANTITE THEORIQUE</th>
                                        <th>QUANTITE PHYSIQUE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($detailInventaires as $detail)
                                        <tr>
                                            <td>{{$detail->libelleArticle}}</td>
                                            <td>{{$detail->quantiteTheorique}}</td>
                                            <td>{{$detail->quantitePhysique}}</td>
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