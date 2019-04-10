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
                    <div class="panel-heading"><span class="fa fa-pencil-square-o"></span>Modification d'un nouveau utilisateur</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{route('utilisateur.update',$users->slug)}}">
                            {{ csrf_field() }}
                            {{method_field('PUT')}}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="nom" class="col-md-4 control-label">Nom</label>

                                <div class="col-md-6">
                                    <input id="nom" type="text" class="form-control" name="name" value="{{$users->nom}}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
                                <label for="prenom" class="col-md-4 control-label">Prenom</label>

                                <div class="col-md-6">
                                    <input id="prenom" type="text" class="form-control" name="prenom" value="{{$users->prenom}}" required>

                                    @if ($errors->has('prenom'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('prenom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $users->email }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('emailSuperieur') ? ' has-error' : '' }}">
                                <label for="emailSuperieur" class="col-md-4 control-label">Mail du seperieur</label>
                                <div class="col-md-6">
                                    <input id="emailSuperieur" type="email" class="form-control" name="emailSuperieur" value="{{$users->emailSuperieur}}" required>

                                    @if ($errors->has('emailSuperieur'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('emailSuperieur') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{$errors->has('role')?'has-error':''}} ">
                                <label for="role" class="col-md-4 control-label">Role</label>
                                <div class="col-md-6">
                                    <select id="role" name="role" class="form-control">
                                        @foreach($roles as $role)
                                            <option value={{$role->role}} @if($role->role ==$users->role) selected @endif>{{$role->role}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('role','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{$errors->has('service')?'has-error':''}} ">
                                <label for="service" class="col-md-4 control-label">SERVICE</label>
                                <div class="col-md-6">
                                    <select id="role" name="service" class="form-control">
                                        @foreach($services as $service)
                                            <option value={{$service->id}} @if($service->id == $users->services_id) selected @endif>{{$service->service}} - {{$service->nomSociete}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('service','<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary fa fa-check">Valider</button>
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