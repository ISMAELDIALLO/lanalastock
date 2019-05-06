@extends('index')
@section('content')
    <div id="wrapper">
        <!-- Navigation -->
        <div id="page-wrapper">
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <h4>CREATION D'UN BON A PAYER</h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-offset-11">
                                <a href="{{route('reception.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
                            </div>
                            <div class="row">
                                <div class="container col-md-12">
                                    @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{session()->get('message')}}
                                        </div>
                                    @endif

                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="">

                                        <div class="col-md-6 col-lg-6 col-md-offset-3">
                                            <form action="{{route('creationBonApayer')}}" method="POST">
                                                {{csrf_field()}}
                                                <div class="form-group col-md-8 col-lg-8">
                                                    <label for="numeroCommande">NUMERO DE LA COMMANDE</label>
                                                    <input type="text" name="numeroCommande" class="form-control" id="">
                                                </div>
                                                <br>
                                               <div class="col-lg-4 col-md-4">
                                                   <button type="submit" class="btn btn-info glyphicon glyphicon-search" ></button>
                                               </div>
                                            </form>
                                        </div>
                                        <!-- /.panel-heading -->
                                        </div>
                                        @if($lignes)
                                            <div class="col-md-6 col-lg-6 col-md-offset-3">
                                                <div class="form-group col-md-8 col-lg-8">
                                                    <span class="">COMMMANDE: {{$codeCommande}}</span>
                                                </div>
                                            </div>
                                        <div class="col-md-7 col-lg-7 col-md-offset-3">
                                            <div class="form-group col-md-8 col-lg-8">
                                                <span class="">FOURNISSEUR: {{$fournisseur}}</span>
                                            </div>
                                        </div>
                                   <div class="col-lg-12 col-sm-12">
                                        <div class="panel-body">
                                            <form action="{{route('detailReception.store')}}" method="post">
                                                {{csrf_field()}}
                                                <section class="table-responsive">
                                                    <table width="100%" class="table table-striped text-center table-bordered table-hover" id="dataTables-example">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">REFERENCE</th>
                                                            <th class="text-center">ARTICLE</th>
                                                            <th class="text-center">QTE COMMANDEE</th>
                                                            <th class="text-center">PU</th>
                                                            <th class="text-center" width="100">QTE LIVREE</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($lignes as $ligne)
                                                            <tr>
                                                                <td>{{$ligne->referenceArticle}}</td>
                                                                <td>{{$ligne->libelleArticle}}</td>
                                                                <td>{{$ligne->quantite}}</td>
                                                                <td>{{strrev(wordwrap(strrev($ligne->prixUnitaire), 3,' ',true))}}</td>
                                                                <td>
                                                                    <input type="text" name="{{'quantiteLivree'}}{{$ligne->id}}" class="form-control text-center" required/>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group col-md-4 col-lg-4 col-md-offset-4">
                                                       <div class="col-md-4 col-lg-4">
                                                           <button type="submit" class="btn btn-info glyphicon glyphicon-ok"></button>
                                                       </div>
                                                    </div>
                                                </section>
                                                <!-- /.table-responsive -->
                                                <br/>
                                            </form>

                                        </div>
                                   </div>
                                        @endif
                                        <!-- /.panel-body -->
                                </div>
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
    </div>
@endsection
