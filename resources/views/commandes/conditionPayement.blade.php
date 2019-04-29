@extends('index')
@section('content')
    <div id="wrapper">

        <!-- Navigation -->


        <div id="page-wrapper">
            <!-- /.row -->

            <!-- /.row -->
            <div class="row">
                <div class="container col-md-12">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{session()->get('message')}}
                        </div>
                    @endif

                </div>
                <div class="container col-md-12">
                    @if(session()->has('message1'))
                        <div class="alert alert-danger">
                            {{session()->get('message1')}}
                        </div>
                    @endif

                </div>
                <div class="col-lg-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="col col-lg-offset-10">
                            <a href="{{route('commande.index')}}" class="btn btn-info fa fa-arrow-left btn-xl"></a>
                        </div>
                        <div class="panel-heading">
                            Conditions de payement de la Commande : {{$commande->codeCommande}}
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                                        <form action="{{route('commande.update', $commande->slug)}}" method="post">
                                            {{csrf_field()}}
                                            {{method_field('PUT')}}
                                             <textarea class="form-control" cols="10" rows="5" name="conditionPayement">{{old('conditionPayement')}}</textarea><br/>

                                            <div>
                                                <button type="submit" class="btn btn-info glyphicon glyphicon-ok">ENREGISTRER</button>
                                                <button type="reset" class="btn btn-danger glyphicon glyphicon-remove"></button>
                                            </div>
                                        </form>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /#wrapper -->
    </div>
@endsection
