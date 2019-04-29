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
                        <div class="col col-lg-offset-9 col-md-offset-9">
                            <a href="{{route('ligneDeCommande.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVELLE COMMANDE</a>
                        </div>
                        <div class="panel-heading">
                            Liste des commandes
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>COMMANDE</th>
                                        <th>ARTICLE</th>
                                        <th>QUANTITE</th>
                                        <th>PRIX UNITAIRE</th>
                                        <th>MONTANT</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($commandes as $commande)
                                        <tr>
                                            <td>{{$commande->codeCommande}}</td>
                                            <td>{{$commande->libelleArticle}}</td>
                                            <td>{{$commande->quantite}}</td>
                                            <td>{{$commande->prixUnitaire}}</td>
                                            <td>{{$commande->quantite*$commande->prixUnitaire}}</td>
                                            <td class="text-center">
                                                <a href="{{route('ligneDeCommande.edit',$commande->slug)}}" class="btn btn-info fa fa-pencil-square-o btn-xl">update</a>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{route('ligneDeCommande.destroy',$commande->slug)}}" method="post" onsubmit="return confirm('Etes vous sùr?')">
                                                    {{csrf_field()}}
                                                    {{method_field('delete')}}
                                                    <button class="btn btn-danger fa fa-times">delete</button>
                                                </form>
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
