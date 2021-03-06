@extends('index')
@section('content')
    <div id="page-wrapper">
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <h3>Formulaire de Modification</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-md-4 col-md-offset-4">
                                <form role="form"  action="{{route('familleArticle.update',$familles->slug)}}" method="POST">
                                    {{csrf_field()}}
                                    {{method_field('PUT')}}
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
                                            <input class="form-control" id="famille" type="text" name="famille" value="{{$familles->libelleFamilleArticle}}">
                                            {!! $errors->first('famille','<span class="help-block alert-danger">:message</span>') !!}
                                            @if(Session::has('warning'))
                                                <span class="help-block alert-danger">La famille article est unique</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row container">
                                        <div class="col-lg-10 col-sm-10 col-md-10">
                                            <button type="submit" class="btn btn-info fa fa-pencil-square-o">update</button>
                                            <div class="col-md-offset-5">
                                                <a href="{{route('familleArticle.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.col-lg-6 (nested) -->
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
@endsection
