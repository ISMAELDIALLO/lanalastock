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
                            <h2>Enregistrement de la facture Proformat</h2>
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
                                <div class="col-lg-12 col-sm-12 col-md-12">
                                    <form action="{{route('detailProformat.store')}}" method="post" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <div class="col-lg-4 col-md-4 col-md-offset-4 col-xs-12">
                                            <div class="form-group">
                                                <label for="fournisseur">FOURNISSEUR</label>
                                                <select name="fournisseur" id="fournisseur" class="form-control">
                                                    @foreach($fournisseurs as $fournisseur)
                                                        <option value="{{$fournisseur->id}}">{{$fournisseur->codeFournisseur}} {{$fournisseur->nomSociete}}</option>
                                                    @endforeach
                                                </select>
                                                {!!$errors->first('fournisseur','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="dateProformat">DATE</label>
                                                <?php $date = new DateTime();?>
                                                <input class="form-control" name="dateProformat" value="<?php echo $date->format('Y-m-d')?>" id="dateCommande" type="date">
                                                {!!$errors->first('dateProformat','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="image">IMAGE</label>
                                                <input class="form-control" name="image" type="file" id="image">
                                                {!!$errors->first('image','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
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
