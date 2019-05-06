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
                            <h4>Enregistrement d'un contrat</h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="container col-md-12">
                                    @if(session()->has('message'))
                                        <div class="alert alert-success">
                                            {{session()->get('message')}}
                                        </div>a
                                    @endif

                                </div>
                                <div class="col-lg-10 col-sm-10 col-md-offset-3">
                                    <form action="{{route('article.store')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="famille">FAMILLE ARTICLE</label>
                                                <select name="famille" id="famille" class="form-control">
                                                    @foreach($familles as $famille)
                                                        <option value="{{$famille->id}}">{{$famille->superCategorie}} {{$famille->libelleFamilleArticle}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('famille','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="libelleContrat">LIBELLE CONTRAT</label>
                                                <input type="text" class="form-control" name="libelleContrat" value="{{ old('libelleContrat') }}" id="libelleContrat">
                                                {!! $errors->first('libelleContrat','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="periodicitePayement">PERIODICITE DE PAYEMENT</label>
                                                <select name="periodicitePayement" id="periodicitePayement" class="form-control">
                                                    <option value="">__select__</option>
                                                    <option value="mensuel">MENSUEL</option>
                                                    <option value="trimestriel">TRIMESTRIEL</option>
                                                    <option value="trimestriel">SEMESTRIEL</option>
                                                    <option value="mensuel">ANNUEL</option>
                                                </select>
                                                {!! $errors->first('periodicitePayement','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="dateDebutContrat">DATE DEBUT CONTRAT</label>
                                                <input type="date" class="form-control" name="dateDebutContrat" value="{{ old('dateDebutContrat') }}" id="dateDebutContrat">
                                                {!! $errors->first('dateDebutContrat','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="dateFinContrat">DATE FIN CONTRAT</label>
                                                <input type="date" class="form-control" name="dateFinContrat" value="{{ old('dateFinContrat') }}" id="dateFinContrat">
                                                {!! $errors->first('dateFinContrat','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="dernierPrix">PRIME</label>
                                                <input class="form-control" name="dernierPrix" value="{{ old('dernierPrix') }}" id="dernierPrix">
                                                {!! $errors->first('dernierPrix','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="row container">
                                            <div class="col-lg-10 col-sm-10 col-md-10">
                                                <button type="submit" class="btn btn-info fa fa-check">
                                                    Enregistrer
                                                </button>
                                                <button type="reset" class="btn btn-danger fa fa-times">Annuler</button>
                                                <div class="col-md-offset-3">
                                                    <a href="{{route('article.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
