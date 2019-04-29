@extends('index')
@section('content')
    <div id="wrapper">

        <!-- Navigation -->


        <div id="page-wrapper">
            <!-- /.row -->
            <!-- /.row -->
            <div class="row">
                <div class="container col-md-12">
                    @if(session()->has('message1'))
                        <div class="alert alert-danger">
                            {{session()->get('message1')}}
                        </div>
                    @endif

                </div>
                <div class="col-lg-8 col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="col-md-offset-11">
                            <a href="{{route('cotation.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
                        </div>
                        <div class="panel-heading">
                            <h3>Les details de la cotation : {{$codeCotation}}</h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center" width="300">ARTICLE</th>
                                        <th class="text-center" width="200">QUANTITE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cots as $cot)
                                        <tr>
                                            <td>{{$cot->libelleArticle}}</td>
                                            <td>{{$cot->quantite}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </section>
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
