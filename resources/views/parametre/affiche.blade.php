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
                    <div class="col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Le mail du gestionnaire et Auditaire
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>EMAIL DU GESTIONNAIRE</th>
                                        <th>EMAIL DE L'AUDITAIRE</th>
                                        <th width="100">MODIFIER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($parametres as $parametre)
                                        <tr>
                                            <td>{{$parametre->mailGestionnaire}}</td>
                                            <td>{{$parametre->mailAuditaire}}</td>
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
