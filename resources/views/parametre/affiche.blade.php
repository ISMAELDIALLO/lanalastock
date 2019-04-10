@extends('index')
@section('content')
    <div id="wrapper">

        <!-- Navigation -->


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tableau</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
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
                    <div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="col col-lg-offset-9">
                            <a href="{{route('parametre.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">CREER</a>
                        </div>
                        <div class="panel-heading">
                            Le mail du gestionnaire
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>EMAIL DU GESTIONNAIRE</th>
                                        <th width="100">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($parametres as $parametre)
                                        <tr>
                                            <td>{{$parametre->mailGestionnaire}}</td>
                                            <td class="text-center">
                                                <a href="{{route('parametre.edit',$parametre->id)}}" class="btn btn-info fa fa-pencil-square-o btn-xl"></a>
                                            </td>
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