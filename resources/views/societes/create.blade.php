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
                            <h3>Formulaire d'ajout de la societe</h3>
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
                                <div class="col-lg-8 col-sm-8 col-md-offset-4">
                                    <form action="{{route('societe.store')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label for="societe">SOCIETE</label>
                                                <input class="form-control" name="societe" value="{{ old('societe') }}" id="societe">
                                                {!! $errors->first('societe','<span class="help-block alert-danger">:message</span>') !!}
                                                @if(Session::has('societeExiste'))
                                                    <span class="help-block alert-danger">Cette societe existe dejà</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="pourcentage">POURCENTAGE</label>
                                                <input class="form-control" name="pourcentage" value="{{ old('pourcentage') }}" id="pourcentage">
                                                {!! $errors->first('pourcentage','<span class="help-block alert-danger">:message</span>') !!}
                                                @if(Session::has('pourcentage'))
                                                    <span class="help-block alert-danger">la somme des pourcentage ne doit pas depasser 100</span>
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
                                                    <a href="{{route('societe.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
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