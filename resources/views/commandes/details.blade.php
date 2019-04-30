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
                        <div class="col col-lg-offset-10">
                            @if($commande->cotations_id == null)
                                <a href="{{route('commandeSpecifique')}}" class="btn btn-info fa fa-arrow-left btn-xl"></a>
                            @else
                                <a href="{{route('commande.index')}}" class="btn btn-info fa fa-arrow-left btn-xl"></a>
                            @endif
                        </div>
                        <div class="panel-heading">
                            Details de la commande : {{$commande->codeCommande}}
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">ARTICLE</th>
                                        <th class="text-center">QUANTITE</th>
                                        <th class="text-center">PRIX UNITAIRE</th>
                                        <th class="text-center">MONTANT</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($details as $detail)
                                        <tr>
                                            <td>{{$detail->libelleArticle}}</td>
                                            <td>{{$detail->quantite}}</td>
                                            <td>{{$detail->prixUnitaire}}</td>
                                            <td>{{$detail->quantite*$detail->prixUnitaire}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </section>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                        <a href="{{route('acount.edit', $commande->id)}}" class="">Effectuer un payement</a>
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
