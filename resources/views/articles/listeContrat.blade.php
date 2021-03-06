
@extends('index')
@section('content')
    <div id="wrapper">

        <!-- Navigation -->


        <div id="page-wrapper">
            <div class="row">
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
                            <a href="{{route('contrat.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVEAU CONTRAT</a>
                        </div>
                        <div class="panel-heading">
                            Liste des contrats
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>CONTRAT</th>
                                        <th>PERIODICITE PAYEMENT</th>
                                        <th>DEBUT CONTRAT</th>
                                        <th>FIN CONTRAT</th>
                                        <th>PRIME</th>
                                        <th>MODIFIER</th>
                                        <th>SUPPRIMER</th>
                                        <th>RENOUVELER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($articles as $article)
                                        <tr>
                                            <td>{{$article->libelleFamilleArticle}} {{$article->referenceArticle}} {{$article->libelleArticle}}</td>
                                            <td>{{$article->periodicitePayement}}</td>
                                            <td>{{$article->dateDebutContrat}}</td>
                                            <td>{{$article->dateFinContrat}}</td>
                                            <td>{{$article->dernierPrix}}</td>
                                            <td class="text-center">
                                                <a href="{{route('contrat.edit',$article->slug)}}" class="btn btn-info fa fa-pencil-square-o btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{route('contrat.destroy',$article->slug)}}" method="post">
                                                    {{csrf_field()}}
                                                    {{method_field('delete')}}
                                                    <button class="btn btn-danger fa fa-trash-o"></button>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('contrat.show',$article->slug)}}" class="btn btn-info glyphicon glyphicon-repeat btn-xl"></a>
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
