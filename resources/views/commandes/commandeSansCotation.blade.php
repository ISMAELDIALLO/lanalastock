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
                            <h4>Enregistrement de la commande</h4>
                            <a href="{{route('commandeSpecifique')}}" class="col-md-offset-9"> Liste des commandes Specifiques</a>
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
                                <div class="col-md-offset-2">
                                    <div class="col-md-10 col-lg-10 col-xs-12">
                                        <form action="{{route('temporaire.store')}}" method="post">
                                            {{csrf_field()}}
                                            <div class="col col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="article">ARTICLES</label>
                                                    <select name="article" id="article" class="form-control">
                                                        @foreach($articles as $article)
                                                            <option value="{{$article->id}}">{{$article->referenceArticle}} {{$article->libelleArticle}}</option>
                                                        @endforeach
                                                    </select>
                                                    {!!$errors->first('article','<span class="help-block alert-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2">
                                                <div class="form-group">
                                                    <label for="quantite">QTE</label>
                                                    <input class="form-control" name="quantite" value="{{old('quantite')}}" id="quantite">
                                                    {!!$errors->first('quantite','<span class="help-block alert-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col col-lg-3 col-md-3">
                                                <div class="form-group">
                                                    <label for="pu">PU</label>
                                                    <input class="form-control" name="prixUnitaire" value="{{old('prixUnitaire')}}" id="prixUnitaire">
                                                    {!!$errors->first('prixUnitaire','<span class="help-block alert-danger">:message</span>') !!}
                                                </div>

                                            </div>
                                            <div class="col col-md-1 col-lg-1">
                                                <label for=""></label>
                                                <button type="submit" class="btn btn-info fa fa-plus"></button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-10 col-md-10">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Lignes de la commande
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
                                                            <th class="text-center" colspan="2">RETIRER</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                                @foreach($lignes as $ligne)
                                                                    <tr>
                                                                        <td>{{$ligne->referenceArticle}} {{$ligne->libelleArticle}}</td>
                                                                        <td>{{$ligne->quantite}}</td>
                                                                        <td>{{$ligne->prixUnitaire}}</td>
                                                                        <td>
                                                                            <form action="{{route('temporaire.destroy',$ligne->id)}}" method="post">
                                                                                {{csrf_field()}}
                                                                                {{method_field('delete')}}
                                                                                <button class="btn btn-danger fa fa-remove"></button>
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
                                    <div class="col-lg-12 col-sm-12">
                                        <form action="{{route('commande.store')}}" method="post">
                                            {{csrf_field()}}
                                            <div class="col-lg-4 col-md-4 col-xs-12">
                                                <div class="row container">
                                                            <div class="col-md-4 col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="fournisseur">FOURNISSEUR</label>
                                                                    <select name="fournisseur" id="fournisseur" class="form-control">
                                                                        @foreach($fournisseurs as $fournisseur)
                                                                            <option value="{{$fournisseur->id}}">{{$fournisseur->nomSociete}} {{$fournisseur->nomDuContact}} {{$fournisseur->prenomDuContact}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    {!!$errors->first('article','<span class="help-block alert-danger">:message</span>') !!}
                                                                </div>
                                                            </div>
                                                    <div class="col-lg-10 col-sm-10 col-md-10">
                                                        <button type="submit" class="btn btn-info fa fa-check">
                                                            ENREGISTRER LA COMMANDE
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
