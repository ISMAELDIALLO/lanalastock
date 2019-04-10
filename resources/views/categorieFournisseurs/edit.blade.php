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
                            <div class="col-lg-4 col-sm-4 col-md-offset-4">
                                <form role="form"  action="{{route('categorieFournisseur.update',$categories->slug)}}" method="POST">
                                    {{csrf_field()}}
                                    {{method_field('PUT')}}
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="categorie">CATEGORIE</label>
                                            <input class="form-control" id="categorie" type="text" name="categorie" value="{{$categories->libelleCategorieFournisseur}}">
                                            {!! $errors->first('categorie','<span class="help-block alert-danger">:message</span>') !!}
                                            @if(Session::has('warning'))
                                                <span class="help-block alert-danger">La categorie du fournisseur est unique</span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="row container">
                                        <div class="col-lg-10 col-sm-10 col-md-10">
                                            <button type="submit" class="btn btn-info fa fa-pencil-square-o">update</button>
                                            <div class="col-md-offset-5">
                                                <a href="{{route('categorieFournisseur.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
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