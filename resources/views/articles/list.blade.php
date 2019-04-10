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
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="col col-lg-offset-10">
                        <a href="{{route('article.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVEL ARTICLE</a>
                        </div>
                        <div class="panel-heading">
                            Liste des articles
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>FAMILLE</th>
                                        <th>REFERENCE</th>
                                        <th>ARTICLE</th>
                                        <th>QUANTITE MINIMUM</th>
                                        <th>QUANTITE MAXIMUM</th>
                                        <th>PRIX D'ACHAT</th>
                                        <th>DATE INVENTAIRE</th>
                                        <th>QUANTITE INVENTAIRE</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($articles as $article)
                                        <tr>
                                            <td>{{$article->libelleFamilleArticle}}</td>
                                            <td>{{$article->referenceArticle}}</td>
                                            <td>{{$article->libelleArticle}}</td>
                                            <td>{{$article->quantiteMinimum}}</td>
                                            <td>{{$article->quantiteMaximum}}</td>
                                            <td>{{$article->dernierPrix}}</td>
                                            <td>{{$article->dateInventaire}}</td>
                                            <td>{{$article->quantiteInventaire}}</td>
                                            <td class="text-center">
                                                <a href="{{route('article.edit',$article->slug)}}" class="btn btn-info fa fa-pencil-square-o btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{route('article.destroy',$article->slug)}}" method="post">
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