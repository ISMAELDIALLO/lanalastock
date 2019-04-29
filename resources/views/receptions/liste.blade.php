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
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="col col-lg-offset-9 col-md-offset-9">
                            <a href="{{route('detailReception.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVELLE RECEPTION</a>
                        </div>
                        <div class="panel-heading">
                            Liste des receptions
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">RECEPTION</th>
                                        <th class="text-center">DATE COMMANDE</th>
                                        <th class="text-center">SOCIETE</th>
                                        <th class="text-center">LE CONTACT</th>
                                        <th>DETAILS</th>
                                        <th>IMPRIMER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($receptions as $reception)
                                        <tr>
                                            <td>{{$reception->codeReception}}</td>
                                            <td>{{$reception->dateReception}}</td>
                                            <td>{{$reception->nomSociete}}</td>
                                            <td>{{$reception->nomDuContact}} {{$reception->prenomDuContact}} {{$reception->telephoneDuContact}}</td>
                                            <td>
                                                <a href="{{route('reception.show',$reception->id)}}" class="btn btn-info fa fa-list btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('reception.edit',$reception->slug)}}" class="btn btn-info fa fa-print btn-xl"></a>
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
