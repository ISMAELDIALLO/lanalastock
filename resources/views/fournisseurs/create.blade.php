@extends('index')
@section('content')
    <div id="wrapper">
        <!-- Navigation -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Enregistrement des fournisseurs</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            Formulaire d'enregistrement
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
                                <div class="col-lg-12 col-sm-12">
                                    <form action="{{route('fournisseur.store')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="famille">CATEGORIE FOURNISSEUR</label>
                                                <select name="categorie" id="categorie" class="form-control">
                                                    @foreach($categories as $categorie)
                                                        <option value="{{$categorie->id}}">{{$categorie->libelleCategorieFournisseur}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('categorie','<span class="help-block">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="nomSociete">SOCIETE</label>
                                                <input class="form-control" name="nomSociete" value="{{ old('nomSociete') }}" id="nomSociete">
                                                {!! $errors->first('nomSociete','<span class="help-block">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="nomContact">NOM DU CONTACT</label>
                                                <input class="form-control" name="nomContact" value="{{ old('nomContact') }}" id="nomContact">
                                                {!! $errors->first('nomContact','<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="prenomContact">PRENOM DU CONTACT</label>
                                                <input class="form-control" name="prenomContact" value="{{ old('prenomContact') }}" id="prenomContact">
                                                {!! $errors->first('prenomContact','<span class="help-block">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="telephone">TELEPHONE DU CONTACT</label>
                                                <input class="form-control" name="telephone" value="{{ old('telephone') }}" id="telephone">
                                                {!! $errors->first('telephone','<span class="help-block">:message</span>') !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="observation">OBSERVATION</label>
                                                <input class="form-control" name="observation" value="{{ old('observation') }}" id="telephone">
                                                {!! $errors->first('observation','<span class="help-block">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="row container">
                                            <div class="col-lg-10 col-sm-10 col-md-10">
                                                <button type="submit" class="btn btn-info fa fa-check">
                                                    Enregistrer
                                                </button>
                                                <button type="reset" class="btn btn-danger fa fa-times">Annuler</button>
                                                <div class="col-md-offset-5">
                                                    <a href="{{route('fournisseur.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
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