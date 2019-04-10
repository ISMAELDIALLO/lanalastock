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
                            <h3>
                                Formulaire de modification
                            </h3>
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
                                <div class="col-lg-6 col-sm-12 col-md-offset-3">
                                    <form action="{{route('temporaireDemande.update',$temporaireDemandes->id)}}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('PUT')}}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="article">ARTICLES</label>
                                                <select name="article" id="article" class="form-control">
                                                    @foreach($articles as $article)
                                                        <option value="{{$article->id}}" @if($article->id == $temporaireDemandes->articles) selected @endif>{{$article->referenceArticle}} {{$article->libelleArticle}}</option>
                                                    @endforeach
                                                </select>
                                                {!!$errors->first('article','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="quantite">QUANTITE</label>
                                                <input class="form-control" name="quantite" value="{{$temporaireDemandes->quantiteDemandee}}" id="quantite">
                                                {!!$errors->first('quantite','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="row container">
                                            <div class="col-lg-10 col-sm-10 col-md-10">
                                                <button type="submit" class="btn btn-info fa fa-check">
                                                    modifier
                                                </button>
                                                <button type="reset" class="btn btn-danger fa fa-times">Annuler</button>
                                                <div class="col-md-offset-5">
                                                    <a href="{{route('detailDemande.create')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
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