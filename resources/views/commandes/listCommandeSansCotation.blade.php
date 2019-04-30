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
                            Liste des commandes sans cotation
                            <a href="{{route('commande.index')}}" class="col-md-offset-9"> Liste des commandes avec cotation</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">COMMANDE</th>
                                        <th class="text-center">DATE COMMANDE</th>
                                        <th class="text-center">SOCIETE</th>
                                        <th class="text-center">LE CONTACT</th>
                                        <th class="text-center" width="100">DETAILS</th>
                                        <th class="text-center">MODE DE PAYEMENT</th>
                                        <th class="text-center" width="100">IMPRIMER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($commandes as $commande)
                                        <tr>
                                            <td>{{$commande->codeCommande}}</td>
                                            <td>{{$commande->dateCommande}}</td>
                                            <td>{{$commande->nomSociete}}</td>
                                            <td>{{$commande->nomDuContact}} {{$commande->prenomDuContact}}</td>
                                            <td>
                                                <a href="{{route('commande.show', $commande->id)}}" class="btn btn-info fa fa-list"></a>
                                            </td>
                                            <td>
                                                <a href="{{route('conditionPayement', $commande->id)}}" class="btn btn-info fa fa-credit-card"></a>
                                            </td>
                                            <td>
                                                <a href="{{route('commande.edit',$commande->id)}}" class="btn btn-info fa fa-print btn-xl"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </section>
                            <br>
                            <!-- /.table-responsive -->
                                <a href="{{route('commande.create')}}">Creer une commande sans cotation</a>
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
