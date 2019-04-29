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
                <div class="col-lg-12 col-md-12 col-md-offset-0">
                    <div class="panel panel-default">
                        <div class="col col-lg-offset-9">
                            <a href="{{route('abilitation.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVELLE HABILITATION</a>
                        </div>
                        <div class="panel-heading">
                            Liste des Utilisateurs qu'on solicite donner des habilitations
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">UTILISATEURS</th>
                                        <th class="text-center">ROLE</th>
                                        <th class="text-center">HABILITATIONS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($habilitations as $habilitation)
                                        <tr>
                                            <td>{{$habilitation->nom}} {{$habilitation->prenom}} {{$habilitation->email}}</td>
                                            <td>{{$habilitation->role}}</td>
                                            <td class="text-center">
                                                <a href="{{route('abilitation.show',$habilitation->id)}}" class="btn btn-info fa fa-list btn-xl"></a>
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
