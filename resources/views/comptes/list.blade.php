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
                <div class="col-md-6 col-lg-6 col-md-offset-3">
                    <form action="{{route('rechercher')}}" method="post" class="form-group">
                        {{method_field('GET')}}
                        {{csrf_field()}}
                        <div class="form-group col-md-5 col-lg-5">
                            <label for="dateDebut">DATE DEBUT</label>
                            <input type="date" id="dateDebut" name="dateDebut" class="form-control">
                        </div>
                        <div class="form-group col-md-5 col-lg-5">
                            <label for="dateFin">DATE FIN</label>
                            <input type="date" id="dateFin" name="dateFin" class="form-control">
                        </div>
                        <div class="col-md-offset-2">
                            <button type="submit" class="btn btn-primary fa fa-check">Rechercher</button>
{{--                            <a href="{{route('printCouts')}}" id="imp" class="col-md-offset-1 fa fa-print btn btn-primary"></a>--}}
                            <a href="{{route('compte.index')}}" class="col-md-offset-1 fa fa-refresh btn btn-primary"></a>
                        </div>
                    </form>
                </div>
                <div class="container col-md-12">
                    @if(session()->has('message1'))
                        <div class="alert alert-danger">
                            {{session()->get('message1')}}
                        </div>
                    @endif

                </div>
                <div class="col-lg-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="col col-lg-offset-9">
                            <a href="{{route('compte.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVEAU COMPTE</a>
                        </div>
                        <div class="panel-heading">
                            @if(isset($titre) )
                                {{$titre}}
                            @else
                                Liste des Comptes
                            @endif
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>COMPTE</th>
                                        <th>MONTANT</th>
                                        <th>DETAILS</th>
                                        <th>MODIFIER</th>
                                        <th>SUPPRIMER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($comptes as $compte)
                                        <tr>
                                            <td>{{$compte->compte}}</td>
                                            <td>{{$compte->montant}}</td>
                                            <td class="text-center">
                                                <a href="{{route('detailCompte.show',$compte->id)}}" class="btn btn-info fa fa-list btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('compte.edit',$compte->id)}}" class="btn btn-info fa fa-pencil-square-o btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{route('compte.destroy',$compte->id)}}" method="post">
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
                    <div>
                        <a href="{{route('detailCompte.index')}}" class="">Compte Principal</a>
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
