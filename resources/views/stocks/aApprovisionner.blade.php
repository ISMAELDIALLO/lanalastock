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
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Article A approvisionner</h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th width="300">ARTICLE</th>
                                        <th width="300">QTE DISPONIBLE</th>
                                        <th width="300">QTE MIN</th>
                                        <th width="300">QTE MAX</th>
                                        <th width="300">QTE A APPROVISIIONNER</th>
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
                                            <td width="150">
                                                <form action="{{--route('detailProformat.update')--}}" method="POST">
                                                    {{csrf_field()}}
                                                    <div class="form-group col-md-2 col-lg-2">
                                                        <input type="text" value="" class="form-control">
                                                        <br>
                                                        <div class="row container">
                                                            <div class="col-lg-2 col-sm-2 col-md-2">
                                                                <button type="submit" class="btn btn-info glyphicon glyphicon-ok">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </section>
                            <!-- /.table-responsive -->
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading text-center">
                                        <h4>Enregistrement de la commande</h4>
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
                                                <form action="{{route('ligneDeCommande.store')}}" method="post">
                                                    {{csrf_field()}}
                                                    <div class="col-lg-4 col-md-4 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="fournisseur">FOURNISSEUR</label>
                                                            <select name="fournisseur" id="fournisseur" class="form-control">

                                                            </select>
                                                            {!!$errors->first('fournisseur','<span class="help-block alert-danger">:message</span>') !!}
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="dateCommande">DATE DE LA COMMANDE</label>
                                                            <?php $date = new DateTime();?>
                                                            <input class="form-control" name="dateCommande" value="<?php echo $date->format('Y-m-d')?>" id="dateCommande" type="date">
                                                            {!!$errors->first('dateCommande','<span class="help-block alert-danger">:message</span>') !!}
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="modePayment">MODE DE PAYEMENT</label>
                                                            <textarea name="modePayement" id="modePayment" cols="30" rows="10"></textarea>
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
