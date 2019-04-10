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
                <div class="col-lg-8 col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Details de la demande :
                            </br><b>CODE :      </b>{{$codeDemande}}
                            </br><b>DEMANDEUR : </b>{{$nom}} {{$prenom}} {{$email}}
                            </br><b>SUPERIEUR : </b>{{$emailSuperieur}}
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>ARTICLE</th>
                                        <th>QUANTITE DEMANDEE</th>
                                        <th>QUANTITE AFFECTEE</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($details as $detail)
                                        <tr>
                                            <td>{{$detail->libelleArticle}}</td>
                                            <td>{{$detail->quantiteDemandee}}</td>
                                            <td>
                                                @if(session('quantiteAffectee'.$detail->detailDemandeId))
                                                    {{session('quantiteAffectee'.$detail->detailDemandeId)}}
                                                @else
                                                    {{0}}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($detail->statut != -1)
                                                <a href="{{route('sortieStock.show', $detail->detailDemandeId)}}" class="btn btn-success fa fa-pencil-square-o btn-xl">Editer</a>
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
                <div class="row col-md-8 col-md-offset-5">
                    <form action="{{route('detailSortieStock.update', $codeDemande)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <div class="form-group-lg">
                            <label for="">SOCIETES</label><br>
                            @foreach($societes as $societe)
                                <input type="checkbox" name="{{$societe->id}}" value="{{$societe->id}}" class="">{{$societe->nomSociete}}<br>
                            @endforeach
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-info btn-xl fa fa-check"></button>
                        </div>
                    </form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /#wrapper -->
    </div>
@endsection
