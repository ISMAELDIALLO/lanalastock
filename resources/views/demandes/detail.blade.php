@extends('index')
@section('content')
    <div id="wrapper" xmlns="http://www.w3.org/1999/html">

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
                <div class="col-lg-10 col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Details de la demande :
                            </br><b>CODE :      </b>{{$codeDemande}}
                            </br><b>DEMANDEUR : </b>{{$nom}} {{$prenom}} {{$email}}
                            </br><b>SUPERIEUR : </b>{{$nomSuperieur}}
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <form action="{{route('detailSortieStock.update', $codeDemande)}}" method="POST">
                                {{method_field('PUT')}}
                                {{csrf_field()}}
                                <section class="table-responsive">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th>ARTICLE</th>
                                            <th>QTE EN STOCK</th>
                                            <th>QTE DEMANDEE</th>
                                            <th width="100">QTE AFFECTEE</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($details as $detail)
                                            <tr>
                                                <td>{{$detail->libelleArticle}}</td>
                                                <td>
                                                    @foreach($stocks as $stk)
                                                        @if($stk->articles_id == $detail->articles_id)
                                                            {{$stk->quaniteStock}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{$detail->quantiteDemandee}}</td>
                                                <td>
                                                    <input type="text" class="form-control text-center" name="{{'quantiteAffectee'}}{{$detail->detailDemandeId}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </section>
                                <button class="btn btn-info col-md-offset-5 glyphicon glyphicon-ok" type="submit"></button>
                            </form>
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
