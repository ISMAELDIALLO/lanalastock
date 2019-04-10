@extends('index')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{session()->get('message')}}
                    </div>
                @endif

            </div>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="fa fa-pencil-square-o"></span>Inscription d'un nouveau utilisateur</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('utilisateur.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="nom" class="col-md-4 control-label">Nom</label>

                                <div class="col-md-6">
                                    <input id="nom" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="prenom" class="col-md-4 control-label">Prenom</label>

                                <div class="col-md-6">
                                    <input id="prenom" type="text" class="form-control" name="prenom" value="{{ old('prenom') }}" required>

                                    @if ($errors->has('prenom'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('prenom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="emailSuperieur" class="col-md-4 control-label">Mail du seperieur</label>
                                <div class="col-md-6">
                                    <input id="emailSuperieur" type="email" class="form-control" name="emailSuperieur" value="{{ old('emailSuperieur') }}" required>

                                    @if ($errors->has('emailSuperieur'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('emailSuperieur') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group  ">
                                <label for="role" class="col-md-4 control-label">Role</label>
                                <div class="col-md-6">
                                    <select id="role" name="role" class="form-control">
                                       @foreach($roles as $role)
                                        <option value={{$role->role}}>{{$role->role}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('role','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="societe_service" class="col-md-4 control-label">SERVICE</label>
                                <div class="col-md-6">
                                    <select id="role" name="service" class="form-control">
                                        @foreach($societe_services as $societe_service)
                                        <option value={{$societe_service->id}}> {{$societe_service->service}}-{{$societe_service->nomSociete}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('societe_service','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Mot de Passe</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirme Mot de Passe</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary fa fa-check"> Enregistrer</button>
                                    <button type="reset" class="btn btn-danger fa fa-times"> Annuler</button>
                                    <div class="col-md-offset-7">
                                        <a href="{{route('utilisateur.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection