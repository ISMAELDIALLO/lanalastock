@extends('index')
@section('content')
    <div id="wrapper">

        <!-- Navigation -->


        <div id="page-wrapper">

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
                <div class="col-lg-8 col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="col col-lg-offset-8">
                            <a href="{{route('categorieFournisseur.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVELLE CATEGORIE</a>
                        </div>
                        <div class="panel-heading">
                            Categories des Fournisseurs
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">CODE</th>
                                        <th class="text-center">LIBELLE</th>
                                        <th width="100">Action</th>
                                        <th width="100">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($categories as $categorie)
                                        <tr>
                                            <td>{{$categorie->codeCategorieFournisseur}}</td>
                                            <td>{{$categorie->libelleCategorieFournisseur}}</td>
                                            <td class="text-center">
                                                <a href="{{route('categorieFournisseur.edit',$categorie->slug)}}" class="btn btn-info fa fa-pencil-square-o btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{route('categorieFournisseur.destroy',$categorie->slug)}}" method="post">
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
