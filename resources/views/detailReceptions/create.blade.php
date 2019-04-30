@extends('index')
@section('content')
    <div id="wrapper">
        <!-- Navigation -->
        <div id="page-wrapper">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <h2>Enregistrement de la reception</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="container col-md-12">
                                    @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{session()->get('message')}}
                                        </div>
                                    @endif

                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Lignes de reception
                                        </div>
                                        <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <form action="{{route('detailReception.store')}}" method="post">
                                                {{csrf_field()}}
                                                <section class="table-responsive">
                                                    <table width="100%" class="table table-striped text-center table-bordered table-hover" id="dataTables-example">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">REFERENCE</th>
                                                            <th class="text-center">ARTICLE</th>
                                                            <th class="text-center">QTE COMMANDEE</th>
                                                            <th class="text-center">PU</th>
                                                            <th class="text-center">QTE LIVREE</th>
                                                            <th class="text-center">FOURNISSEUR</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($lignes as $ligne)
                                                            <tr>
                                                                <td>{{$ligne->referenceArticle}}</td>
                                                                <td>{{$ligne->libelleArticle}}</td>
                                                                <td>{{$ligne->quantite}}</td>
                                                                <td>{{$ligne->prixUnitaire}}</td>
                                                                <td>{{$ligne->nomSociete}} {{$ligne->nomDuContact}} {{$ligne->prenomDuContact}}</td>
                                                                <td>
                                                                    <input type="text" name="{{'quantiteLivree'}}{{$ligne->id}}" class="form-control"/>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </section>
                                                <!-- /.table-responsive -->
                                                <br/><button type="submit" class="btn btn-info">ENREGISTRER LE BON DE RECEPTION</button>
                                            </form>

                                        </div>
                                        <!-- /.panel-body -->
                                    </div>
                                </div>
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
    </div>
@endsection
