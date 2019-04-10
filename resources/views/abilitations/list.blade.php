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
                <div class="col-lg-12 col-md-12 col-md-offset-0">
                    <div class="panel panel-default">
                        <div class="col col-lg-offset-9">
                            <a href="{{route('abilitation.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVELLE HABILITATION</a>
                        </div>
                        <div class="panel-heading">
                            Liste des Habilitations
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>UTILISATEURS</th>
                                        <th>SOUS MENUS</th>
                                        <th>MODIFIER</th>
                                        <th>SUPPRIMER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($habilitations as $habilitation)
                                        <tr>
                                            <td>{{$habilitation->nom}} {{$habilitation->prenom}} {{$habilitation->email}}</td>
                                            <td>{{$habilitation->nomSousMenu}}</td>
                                            <td class="text-center">
                                                <a href="{{route('abilitation.edit',$habilitation->id)}}" class="btn btn-info fa fa-pencil-square-o btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{route('abilitation.destroy',$habilitation->id)}}" method="post">
                                                    {{csrf_field()}}
                                                    {{method_field('delete')}}
                                                    <button class="btn btn-danger fa fa-trash-o"></button>
                                                </form>
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
