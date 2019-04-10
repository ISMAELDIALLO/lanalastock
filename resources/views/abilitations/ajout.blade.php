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
                            <h3>Formulaire d'enregistrement</h3>
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
                                <div class="col-lg-8 col-sm-8 col-md-8 col-md-offset-2">
                                    <form action="{{route('abilitation.store')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="utilisateur">UTILISATEUR</label>
                                                <select name="utilisateur" id="utilisateur" class="form-control">
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}">{{$user->email}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('utilisateur','<span class="help-block alert-danger">:message</span>') !!}
                                            </div>
                                            <div class="form-group-lg">
                                                <div class="row">
                                                    <ul class="nav" id="side-menu">
                                                        @foreach($menus as $menu)
                                                            <div class="col-md-4">
                                                            <li>
                                                                <label for="">{{$menu->nomMenu}}</label><br>
                                                                <ul class="nav nav-second-level">
                                                                    @foreach($sousMenus as $sousMenu)
                                                                            @if($sousMenu->menus_id == $menu->id)
                                                                                <li>
                                                                                    <input type="checkbox" name="{{$sousMenu->id}}" value="{{$sousMenu->id}}">{{$sousMenu->nomSousMenu}}<br>
                                                                                </li>
                                                                            @endif
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                            </div>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            @if(Session::has('doublons'))
                                                    <span class="alert alert-danger"><b>Ce</b> Menu est deja associe à cet utilisateur</span>
                                            @endif
                                        </div>
                                        <div class="row container">
                                            <div class="col-lg-10 col-sm-10 col-md-10">
                                                <button type="submit" class="btn btn-info fa fa-check">
                                                    Enregistrer
                                                </button>
                                                <button type="reset" class="btn btn-danger fa fa-times">Annuler</button>
                                                <div class="col-md-offset-5">
                                                    <a href="{{route('abilitation.index')}}" class="glyphicon glyphicon-arrow-left btn btn-info"></a>
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
