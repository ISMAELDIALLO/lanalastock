@extends('index')
@section('content')
    <div id="wrapper">

        <!-- Navigation -->


        <div id="page-wrapper">

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
                        <div class="col col-lg-offset-8">
                            <a href="{{route('familleArticle.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVELLE FAMILLE</a>
                        </div>
                        <div class="panel-heading">
                            Famille des articles
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>CODE</th>
                                        <th>SUPER CATEGORE ARTICLE</th>
                                        <th>TYPE IMPUTATION</th>
                                        <th>LIBELLE FAMILLE</th>
                                        <th width="100">MODIFIER</th>
                                        <th width="100">SUPPRIMER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($familles as $famille)
                                        <tr>
                                            <td>{{$famille->codeFamilleArticle}}</td>
                                            <td>{{$famille->superCategorie}}</td>
                                            <td>{{$famille->typeImputation}}</td>
                                            <td>{{$famille->libelleFamilleArticle}}</td>
                                            <td class="text-center">
                                                <a href="{{route('familleArticle.edit',$famille->slug)}}" class="btn btn-info fa fa-pencil-square-o btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{route('familleArticle.destroy',$famille->slug)}}" method="post" onsubmit="return confirm('Etes vous sùr?')">
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
