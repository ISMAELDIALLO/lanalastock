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
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Liste des commandes
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">REF PAYEMENT</th>
                                        <th class="text-center">COMMANDE</th>
                                        <th class="text-center">FOURNISSEUR</th>
                                        <th class="text-center">DATE COMMANDE</th>
                                        <th class="text-center">MONTANT PAYER</th>
                                        <th class="text-center" width="100">IMPRIMER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($acounts as $acount)
                                        <tr>
                                            <td>{{$acount->referencePayement}}</td>
                                            <td>{{$acount->codeCommande}}</td>
                                            <td>{{$acount->nomSociete}} {{$acount->nomDuContact}} {{$acount->prenomDuContact}}</td>
                                            <td>{{$acount->dateCommande}}</td>
                                            <td>{{$acount->montantPaye}}</td>
                                            <td>
                                                <a href="{{route('acount.show',$acount->id)}}" class="btn btn-info fa fa-print btn-xl"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </section>
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
