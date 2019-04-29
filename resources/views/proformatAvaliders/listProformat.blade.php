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
                            Liste des factures proformats à valider
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <section class="table-responsive">
                                <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">CODE FACTURE</th>
                                        <th class="text-center">DATE </th>
                                        <th class="text-center">SOCIETE</th>
                                        <th class="text-center">LE CONTACT</th>
                                        <th class="text-center" width="100">VOIR</th>
                                        <th class="text-center" width="100">VALIDER</th>
                                        <th class="text-center" width="100">REJETTER</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($proformats as $proformat)
                                        <tr>
                                            <td>{{$proformat->codeProformat}}</td>
                                            <td>{{$proformat->dateProformat}}</td>
                                            <td>{{$proformat->nomSociete}}</td>
                                            <td>{{$proformat->nomDuContact}} {{$proformat->prenomDuContact}} {{$proformat->telephoneDuContact}}</td>
                                            <td>
                                                <a href="{{route('traiteFacture.show',$proformat->codeProformat)}}" class="btn btn-info glyphicon glyphicon-list btn-xl"></a>
                                            </td>
                                            <td>
                                                @if($proformat->etat==1)
                                                    <a href="{{route('traiteFacture.edit', $proformat->codeProformat)}}" class="btn btn-info glyphicon glyphicon-ok"></a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('rejettrerProformat',$proformat->codeProformat)}}" class="btn btn-danger glyphicon glyphicon-remove btn-xl"></a>
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
