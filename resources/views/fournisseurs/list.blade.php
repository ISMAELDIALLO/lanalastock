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
                        <div class="col col-lg-offset-9">
                            <a href="{{route('fournisseur.create')}}" class="btn btn-info fa fa-plus-circle btn-xl">NOUVEAU FOURNISSEUR</a>
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
                                        <th>CATEGORIE</th>
                                        <th>CODE FOURNISSEUR</th>
                                        <th>NOM SOCIETE</th>
                                        <th>NOM DU CONTACT</th>
                                        <th>PRENOM DU CONTACT</th>
                                        <th>TELEPHONE</th>
                                        <th>OBSERVATION</th>
                                        <th>Action</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($fournisseurs as $fournisseur)
                                        <tr>
                                            <td>{{$fournisseur->libelleCategorieFournisseur}}</td>
                                            <td>{{$fournisseur->codeFournisseur}}</td>
                                            <td>{{$fournisseur->nomSociete}}</td>
                                            <td>{{$fournisseur->nomDuContact}}</td>
                                            <td>{{$fournisseur->prenomDuContact}}</td>
                                            <td>{{$fournisseur->telephoneDuContact}}</td>
                                            <td>{{$fournisseur->observation}}</td>
                                            <td class="text-center">
                                                <a href="{{route('fournisseur.edit',$fournisseur->slug)}}" class="btn btn-info fa fa-pencil-square-o btn-xl"></a>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{route('fournisseur.destroy',$fournisseur->slug)}}" method="post">
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