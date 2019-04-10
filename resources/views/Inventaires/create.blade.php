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
                            <h2>Enregistrement de l'inventaire</h2>
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
                                    <form action="{{route('detailInventaire.store')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-lg-4 col-md-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="dateInventaire">DATE DE L'INVENTAIRE</label>
                                                <input class="form-control" name="dateInventaire" value="<?php $date = new DateTime(); echo $date->format('Y-m-d');?>" id="dateInventaire" type="date">
                                                {!!$errors->first('dateInventaire','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="row container">
                                                <div class="col-lg-10 col-sm-10 col-md-10">
                                                    <button type="submit" class="btn btn-info fa fa-check">
                                                        Valider
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-md-8 col-lg-8 col-xs-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Lignes de l'inventaire
                                            </div>
                                            <!-- /.panel-heading -->
                                            <div class="panel-body">
                                                <section class="table-responsive">
                                                    <table width="100%" class="table table-striped text-center table-bordered table-hover" id="dataTables-example">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">ARTICLE</th>
                                                            <th class="text-center">QUANTITE THEORIQUE</th>
                                                            <th class="text-center">QUANTITE PHYSIQUE</th>
                                                            <th class="text-center" colspan="2">Actions</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($lignes as $ligne)
                                                            <tr>
                                                                <td>{{$ligne->libelleArticle}}</td>
                                                                <td>{{$ligne->quaniteStock}}</td>
                                                                <td>
                                                                    @if(session('quantitePhysique'.$ligne->articles_id))
                                                                        {{session('quantitePhysique'.$ligne->articles_id)}}
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="{{route('inventaire.edit',$ligne->articles_id)}}" class="btn btn-info fa fa-pencil-square-o btn-xl">modifier</a>
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