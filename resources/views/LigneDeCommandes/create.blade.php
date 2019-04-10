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
                            <h2>Enregistrement de la commande</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="container col-md-12">
                                    @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{session()->get('message')}}
                                        </div>a
                                    @endif

                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <form action="{{route('ligneDeCommande.store')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-lg-4 col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="fournisseur">FOURNISSEUR</label>
                                                <select name="fournisseur" id="fournisseur" class="form-control">
                                                    @foreach($fournisseurs as $fournisseur)
                                                        <option value="{{$fournisseur->id}}">{{$fournisseur->codeFournisseur}} {{$fournisseur->nomSociete}}</option>
                                                    @endforeach
                                                </select>
                                                {!!$errors->first('fournisseur','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="dateCommande">DATE DE LA COMMANDE</label>
                                                <?php $date = new DateTime();?>
                                                <input class="form-control" name="dateCommande" value="<?php echo $date->format('Y-m-d')?>" id="dateCommande" type="date">
                                                {!!$errors->first('dateCommande','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="row container">
                                                <div class="col-lg-10 col-sm-10 col-md-10">
                                                    <button type="submit" class="btn btn-info fa fa-check">
                                                        VALIDER
                                                    </button>
                                                    <div class="col-md-offset-3">
                                                        <a href="{{route('commande.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-md-8 col-lg-8 col-xs-12">
                                        <div class="panel panel-default">
                                            <div class="col col-lg-offset-9">
                                                <a href="{{route('temporaire.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">REMPLIR LE PANIER</a>
                                            </div>
                                            <div class="panel-heading">
                                                Lignes de commande
                                            </div>
                                            <!-- /.panel-heading -->
                                            <div class="panel-body">
                                                <section class="table-responsive">
                                                    <table width="100%" class="table table-striped text-center table-bordered table-hover" id="dataTables-example">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">ARTICLE</th>
                                                            <th class="text-center">QUANTITE</th>
                                                            <th class="text-center">PRIX UNITAIRE</th>
                                                            <th class="text-center" colspan="2">Actions</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($lignes as $ligne)
                                                            <tr>
                                                                <td>{{$ligne->libelleArticle}}</td>
                                                                <td>{{$ligne->quantite}}</td>
                                                                <td>{{$ligne->dernierPrix}}</td>
                                                                <td class="text-center">
                                                                    <a href="{{route('temporaire.edit',$ligne->id)}}" class="btn btn-info fa fa-pencil-square-o btn-xl">modifier</a>
                                                                </td>
                                                                <td class="text-center">
                                                                    <form action="{{route('temporaire.destroy',$ligne->id)}}" method="post">
                                                                        {{csrf_field()}}
                                                                        {{method_field('delete')}}
                                                                        <button class="btn btn-danger fa fa-times">retirer</button>
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