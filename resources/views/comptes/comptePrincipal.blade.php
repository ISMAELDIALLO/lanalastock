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
                <div class="col-lg-6 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="col col-lg-offset-11">
                            <a href="{{route('compte.index')}}" class="btn btn-info glyphicon glyphicon-arrow-left btn btn-info btn-xl"></a>
                        </div>
                        <div class="panel-heading">
                            Le Compte Principal
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">MONTANT</th>
                                        <th class="text-center">LIQUIDER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($comptePrincipals as $comptePrincipal)
                                        <tr>
                                            <td>{{$comptePrincipal->montant}}</td>
                                            <td class="text-center">
                                                <a href="{{route('detailCompte.edit',$comptePrincipal->id)}}" class="btn btn-info fa fa-pencil-square-o btn-xl"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </section>
                            <!-- /.table-responsive -->
                        </div>
                        <br><br>

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