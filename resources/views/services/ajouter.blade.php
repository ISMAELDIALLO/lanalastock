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
                            <h3>Ajout d'un nouveau service</h3>
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
                                    <form action="{{route('service.store')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label for="societe">SOCIETE</label>
                                                    @foreach($societes as $societe)
                                                        <input type="checkbox" value="{{$societe->id}}" name="{{$societe->nomSociete}}">{{$societe->nomSociete}}
                                                    @endforeach
                                                {!! $errors->first('societe','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="service">SERVICE</label>
                                                <input class="form-control" name="service" value="{{old('service')}}" id="service">
                                                {!! $errors->first('service','<span class="help-block alert-danger">:message</span>') !!}
                                                @if(Session::has('serviceExiste'))
                                                    <span class="help-block alert-danger">Ce service existe dejà</span>
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
                                                    <a href="{{route('service.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
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