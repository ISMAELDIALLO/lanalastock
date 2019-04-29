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
                            <h4>Changement d'habilitation pour l'utilisateur</h4>
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
                                <div class="col-lg-4 col-sm-4 col-md-offset-4">
                                    <form action="{{route('abilitation.update',$habilitations->id)}}" method="post">
                                        {{csrf_field()}}
                                        {{method_field('PUT')}}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="utilisateur">UTILISATEUR</label>
                                                <select name="utilisateur" id="utilisateur" class="form-control">
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}" @if($user->id == $habilitations->users_id ) selected @endif>{{$user->nom}} {{$user->prenom}} {{$user->email}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('utilisateur','<span class="help-block alert-danger">:message</span>') !!}
                                            </div><br>
                                            <div class="form-group-lg">
                                                <label for="sousMenu">SOUS MENU</label><br>
                                                <select name="sousMenu" class="form-control" id="sousMenu">
                                                    @foreach($sousMenus as $sousMenu)
                                                        <option value="{{$sousMenu->id}}" @if($sousMenu->id == $habilitations->sous_menu_id) selected @endif>{{$sousMenu->lien}}</option>
                                                        <br>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if(Session::has('doublons'))
                                                <span class="alert alert-danger"><b>Sous Menu attribué au meme utilisateur</b></span>
                                            @endif
                                        </div>

                                        <div class="row container">
                                            <div class="col-lg-10 col-sm-10 col-md-10"><br><br>
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
