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
                            <h2>Enregistrement d'un commentaire</h2>
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
                                <div class="col-lg-12 col-sm-12">
                                    <form action="{{route('detailProformat.update', $codeProformats)}}" method="POST">
                                        {{csrf_field()}}
                                        {{method_field('PUT')}}
                                            <div class="form-group col-md-8 col-lg-8 col-md-offset-2">
                                                <label for="commentaire">JUSTIFICATION DE CHOIX</label>
                                                <textarea id="commmentaire" name="commentaire" class="form-control">

                                                </textarea>
                                                <br>
                                                <div class="row container">
                                                    <div class="col-lg-10 col-sm-10 col-md-10">
                                                        <button type="submit" class="btn btn-info fa fa-check">
                                                            VALIDER
                                                        </button>
                                                        <div class="col-md-offset-3">
                                                            <a href="{{route('proformat.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
                                                        </div>
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
