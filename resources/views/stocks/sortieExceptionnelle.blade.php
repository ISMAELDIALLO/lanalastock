@extends('index')
@section('content')
    <div id="wrapper">
        <!-- Navigation -->
        <div id="page-wrapper">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8 col-md-offset-2">
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
                                <div class="col-lg-4 col-sm-12 col-md-offset-3">
                                    <form action="{{route('stock.store')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="motif">ARTICLE</label>
                                                <select class="form-control" name="article" id="article">
                                                    @foreach($articles as $article)
                                                        <option value="{{$article->id}}">{{$article->libelleArticle}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('motif','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="quantite">QUANTITE A DIMINUER</label>
                                                <input class="form-control" name="quantite" value="{{old('qunaite')}}" id="quantite">
                                                {!! $errors->first('quantite','<span class="help-block alert-danger">:message</span>') !!}
                                                @if(Session::has('warning'))
                                                    <div class="has-error alert-danger">
                                                        <b>Attention!</b>, quantite indisponible en stock
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="motif">LE MOTIF</label>
                                                <select class="form-control" name="motif" id="motif">
                                                    @foreach($motifs as $motif)
                                                        <option value="{{$motif->motif}}">{{$motif->motif}}</option>
                                                        @endforeach
                                                </select>
                                                {!! $errors->first('motif','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="row container">
                                            <div class="col-lg-10 col-sm-10 col-md-10">
                                                <button type="submit" class="btn btn-info fa fa-check">
                                                    Enregistrer
                                                </button>
                                                <button type="reset" class="btn btn-danger fa fa-times">Annuler</button>
                                                <div class="col-md-offset-5">
                                                    <a href="{{route('stock.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
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