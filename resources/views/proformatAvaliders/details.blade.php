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
                <div class="col-lg-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="col col-lg-offset-10">
                            <a href="{{route('traiteFacture.index')}}" class="btn btn-info fa fa-arrow-left btn-xl"></a>
                        </div>
                        <div class="panel-heading">
                            CODE PROFORMAT : {{$details->codeProformat}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-md-offset-3">
                            <div class="thumbnail">
                                <div class="caption text-center">
                                    <h3>FACTURE PROFORMAT</h3>
                                </div>
                                <div class="caption text-center">
                                    <span>
                                        {{$details->commentaires}}
                                    </span>
                                </div>
                                <p class="col-md-offset-5">
                                    <a href="{{route('detailProformat.show',$details->codeProformat)}}" class="btn btn-primary glyphicon glyphicon-file" role="button"></a>
                                </p>
                            </div>
                        </div>
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
