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
                                <div class="col-lg-8 col-sm-8 col-md-offset-4">
                                    <form action="{{route('message.store')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="messageGestionnaire"> MESSAGE ENVOYER AU GESTIONNAIRE</label>
                                                <textarea class="form-control" name="messageGestionnaire" value="{{ old('messageGestionnaire') }}" id="message"></textarea>
                                                {!! $errors->first('messageGestionnaire','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="messageSuperieur"> MESSAGE ENVOYER AU SUPERIEUR </label>
                                                <textarea class="form-control" name="messageSuperieur" value="{{ old('message') }}" id="message"></textarea>
                                                {!! $errors->first('message','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            @if(Session::has('UNE_LIGNE'))
                                                    <span class="alert alert-danger">Les messages sont uniques vous pouvez modifier</span>
                                            @endif
                                        </div>
                                        <div class="row container">
                                            <div class="col-lg-10 col-sm-10 col-md-10">
                                                <button type="submit" class="btn btn-info fa fa-check">
                                                    Enregistrer
                                                </button>
                                                <button type="reset" class="btn btn-danger fa fa-times">Annuler</button>
                                                <div class="col-md-offset-5">
                                                    <a href="{{route('message.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
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