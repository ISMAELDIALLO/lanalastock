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
                            <h3>Formulaire de mofication</h3>
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
                                    <form action="{{route('service.update',$service->slug)}}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('PUT')}}
                                        <div class="col-lg-4 col-md-4 ">
                                            <div class="form-group">
                                                <label for="societe">SOCIETE</label>
                                                <select name="societe" id="societe" class="form-control">
                                                    @foreach($societes as $societe)
                                                        <option value="{{$societe->id}}" @if($societe->id == $service->societes_id) selected @endif>{{$societe->nomSociete}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('societe','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="service">SERVICE</label>
                                                <input class="form-control" name="service" value="{{$service->service}}" id="service">
                                                {!! $errors->first('service','<span class="help-block alert-danger">:message</span>') !!}
                                                @if(Session::has('serviceExiste'))
                                                    <span class="help-block alert-danger">Ce service existe dejà</span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="pourcentage">POURCENTAGE</label>
                                                <input class="form-control" name="pourcentage" value="{{$service->pourcentage}}" id="pourcentage">
                                                {!! $errors->first('pourcentage','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="pourcentage_vie">POURCENTAGE VIE</label>
                                                <input class="form-control" name="pourcentage_vie" value="{{$service->pourcentage_vie}}" id="pourcentage_vie">
                                                {!! $errors->first('pourcentage_vie','<span class="help-block alert-danger">:message</span>') !!}
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