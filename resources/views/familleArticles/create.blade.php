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
                           <h3>Formulaire d'enregistrement</h3>
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
                                    <form action="{{route('familleArticle.store')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="famille"> SUPER CATEGORIE ARTICLE</label>
                                                <select name="categorie" id="categorie" class="form-control">
                                                    @foreach($categories as $categorie)
                                                        <option value="{{$categorie->id}}">{{$categorie->superCategorie}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('categorie','<span class="help-block">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="typeImputation"> TYPE IMPUTATION</label>
                                                <select name="typeImputation" id="typeImputation" class="form-control">
                                                        <option value="immo">IMMOBILISATION</option>
                                                        <option value="moyensGeneraux">MOYENS GENERAUX</option>
                                                </select>
                                                {!! $errors->first('categorie','<span class="help-block">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="famille">FAMILLE</label>
                                                <input class="form-control" name="famille" value="{{ old('famille') }}" id="famille">
                                                {!! $errors->first('famille','<span class="help-block alert-danger">:message</span>') !!}
                                                @if(Session::has('warning'))
                                                    <span class="help-block alert-danger">La famille article est unique</span>
                                                    @endif
                                            </div>
                                        </div>
                                        <div class="row container">
                                            <div class="col-lg-10 col-sm-10 col-md-10">
                                                <button type="submit" class="btn btn-info fa fa-check">
                                                    Enregistrer
                                                </button>
                                                <button type="reset" class="btn btn-danger fa fa-times">Annuler</button>
                                                <div class="col-md-offset-5">
                                                    <a href="{{route('familleArticle.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
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
