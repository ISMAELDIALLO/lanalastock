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
                            <a href="{{route('printCouts')}}" id="imp" class="col-md-offset-1 fa fa-print btn btn-primary"></a>
                            <a href="{{route('coutsParService')}}" class="col-md-offset-1 fa fa-refresh btn btn-primary"></a>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="col-md-offset-5">Les couts par service</h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body col-md-offset-1">
                            <section class="table-responsive">
                                <table width="80%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">SERVICE</th>
                                        <th class="text-center">COUT VIE</th>
                                        <th class="text-center">COUT IARD</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($couts as $cout)
                                        <tr>
                                            <td>{{$cout->service}}-{{$cout->nomSociete}}</td>
                                            <td>{{$cout->cout*$cout->pourcentage_vie/100}}</td>
                                            <td>{{$cout->cout*$cout->pourcentage/100}}</td>
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