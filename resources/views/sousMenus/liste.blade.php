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
                        <div class="col col-lg-offset-8">
                            <a href="{{route('sousMenu.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVEAU SOUS MENU</a>
                        </div>
                        <div class="panel-heading">
                            Liste des sous-menus
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive col-md-offset-0">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">MENU</th>
                                        <th class="text-center">SOUS MENU</th>
                                        <th class="text-center">LIEN</th>
                                        <th class="text-center" width="100">MODIFIER</th>
                                        <th class="text-center" width="100">SUPPRIMER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sousMenus as $menu)
                                        <tr>
                                            <td>{{$menu->nomMenu}}</td>
                                            <td>{{$menu->nomSousMenu}}</td>
                                            <td>{{$menu->lien}}</td>
                                            <td class="text-center">
                                                <a href="{{route('sousMenu.edit',$menu->slug)}}" class="btn btn-info fa fa-pencil-square-o btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{route('sousMenu.destroy',$menu->slug)}}" method="post">
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
