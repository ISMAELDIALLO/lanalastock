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
                            La quantite à affecter
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
                                <div class="col-lg-6 col-sm-12 col-md-offset-4">
                                    <form action="{{route('sortieStock.update', $detailDemande->id)}}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('PUT')}}
                                        <div class="col-lg-6 col-md-4">
                                            <div class="form-group">
                                                <label for="quantite">QUANTITE DE "{{$articleDemande}}" A AFFECTER</label>
                                                <input class="form-control" name="quantite" value="{{ old('quantite') }}" id="quantite">
                                                {!! $errors->first('quantite','<span class="help-block alert-danger">:message</span>') !!}

                                                @if(Session::has('warning'))
                                                    <span class="help-block alert-danger">Quantite indisponible en stock</span>
                                                @elseif(Session::has('stockVide'))
                                                    <span class="help-block alert-danger">Stock vide</span>
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
                                                    <a href="{{route('demande.show',$detailDemande->demandes_id)}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
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