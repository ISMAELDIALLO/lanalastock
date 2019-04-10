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
                            <h3>Formulaire de mise a jour</h3>
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
                                <div class="col-lg-4 col-sm-4 col-md-offset-4">
                                    <form action="{{route('article.update',$articles->slug)}}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('PUT')}}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="famille">FAMILLE ARTICLE</label>
                                                <select name="famille" id="famille" class="form-control">
                                                    @foreach($familles as $famille)
                                                        <option value="{{$famille->id}}" @if($famille->id == $articles->famille_articles_id) selected @endif>{{$famille->libelleFamilleArticle}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('famille','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="libelle">ARTICLE</label>
                                                <input class="form-control" name="libelle" value="{{ $articles->libelleArticle }}" id="libelle">
                                                {!! $errors->first('libelle','<span class="help-block alert-danger">:message</span>') !!}
                                                @if(Session::has('warning'))
                                                    <span class="help-block alert-danger">Le libelle de l'article est unique</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="quantiteminimum">QUANTITE MINIMUM</label>
                                                <input class="form-control" name="quantiteminimum" value="{{ $articles->quantiteMinimum }}" id="quantiteminimum">
                                                {!! $errors->first('quantiteminimum','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="quantitemaximum">QUANTITE MAXIMUM</label>
                                                <input class="form-control" name="quantitemaximum" value="{{ $articles->quantiteMaximum }}" id="quantitemaximum">
                                                {!! $errors->first('quantitemaximum','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="dernierPrix">PRIX D'ACHAT</label>
                                                <input class="form-control" name="dernierPrix" value="{{ $articles->dernierPrix }}" id="dernierPrix">
                                                {!! $errors->first('dernierPrix','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="row container">
                                            <div class="col-lg-10 col-sm-10 col-md-10">
                                                <button type="submit" class="btn btn-info fa fa-check">
                                                    Enregistrer
                                                </button>
                                                <button type="reset" class="btn btn-danger fa fa-times">Annuler</button>
                                                <div class="col-md-offset-5">
                                                    <a href="{{route('article.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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