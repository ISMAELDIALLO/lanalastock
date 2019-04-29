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
                <div class="col-lg-10 col-md-10 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Les habilitations de l'utilisateur
                            <a href="{{route('abilitation.index')}}" class="col-md-offset-8 glyphicon glyphicon-arrow-left btn btn-primary"></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="panel-heading">
                                    <b>LES INFORMATIONS DE L'UTILISATEUR</b> :
                                </br><b>UTILISATEUR :      </b>{{$nomUtilisateur}} {{$prenomUtilisateur}}
                                </br><b>EMAIL : </b> {{$emailUtilisateur}}
                            </div>
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">SOUS MENU</th>
                                        <th class="text-center">LIEN</th>
                                        <th class="text-center">SUPPRIMER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($habilitations as $habilitation)
                                        <tr>
                                            <td>{{$habilitation->nomSousMenu}}</td>
                                            <td>{{$habilitation->lien}}</td>
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
