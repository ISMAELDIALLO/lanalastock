@extends('index')
@section('content')
    <div id="wrapper">
        <!-- Navigation -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Enregistrement du Gestionnaire</h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
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
                                    <form action="{{route('parametre.store')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="email">EMAIL DU GESTIONNAIRE</label>
                                                <input class="form-control" name="email" value="{{old('email')}}" id="email" TYPE="email">
                                                {!!$errors->first('email','<span class="help-block alert-danger">:message</span>') !!}
                                                @if(Session::has('warning'))
                                                    <span class="help-block alert-danger">Impossible d'enregistrer deux mails pour le gestionnaire</span>
                                                    @endif
                                            </div>
                                        </div>
                                        <div class="row container">
                                            <div class="col-lg-10 col-sm-10 col-md-10">
                                                <button type="submit" class="btn btn-info fa fa-check">
                                                    Enregistrer
                                                </button>
                                                <div class="col-md-offset-5">
                                                    <a href="{{route('parametre.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
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