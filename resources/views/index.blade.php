<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    @if(auth()->user() == false)
        <META HTTP-EQUIV="refresh" content="1;URL=/login">
    @endif

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{asset('vendor/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('dist/css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{asset('vendor/morrisjs/morris.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
    <!-- DataTables CSS -->
    <link href="{{asset('vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{asset('vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery.min.js"></script>

    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet'>
    <![endif]-->
     <?php
        //dd($demandes);
            $valeur=compteur();
        ?>
</head>

<div>
<div class="col-lg-12 col-md-12 thumbnail">
    <!--<img src="img/Voting-Recovered.jpg" alt="brttc" style="background-color:inherit">-->
    <div id="wrapper">

        <!-- Navigation -->

        <div class="navbar-default sidebar" role="navigation" style="background-color: #ffffff; font-size: larger; font-size: 18px;font-family: 'Times New Roman'">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="{{route('home')}}"><i class="fa fa-dashboard fa-fw"></i> ACCUEIL</a>
                    </li>
                    @if(auth()->user())
                        @if(auth()->user()->role=="administrateur")
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>STRUCTURE<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('article.index')}}"><span class="fa fa-plus-circle">Articles</span></a>
                                </li>
                                <li>
                                    <a href="{{route('fournisseur.index')}}"><span class="fa fa-plus-circle">Fournisseurs</span></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>STOCK<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('stock.index')}}"><span class="fa fa-plus-circle">Articles en stock</span></a>
                                </li>
                                <li>
                                    <a href="{{route('aApprovisionner')}}"><span class="fa fa-plus-circle">A Approvisionner</span></a>
                                </li>
                                <li>
                                    <a href="{{route('proformat.index')}}"><span class="fa fa-plus-circle">Proformat</span></a>
                                </li>
                                <li>
                                    <a href="{{route('proformat.create')}}"><span class="fa fa-plus-circle">Toutes Les Factures</span></a>
                                </li>
                                <li>
                                    <a href="{{route('traiteFacture.index')}}"><span class="fa fa-plus-circle">Traiter Facture</span></a>
                                </li>
                                <li>
                                    <a href="{{route('detailCotation.create')}}"><span class="fa fa-plus-circle">Cotations</span></a>
                                </li><li>
                                    <a href="{{route('commande.index')}}"><span class="fa fa-plus-circle">Commandes</span></a>
                                </li>
                                <li>
                                    <a href="{{route('reception.index')}}"><span class="fa fa-plus-circle">Receptions</span></a>
                                </li>

                                <li>
                                    <a href="{{route('detailDemande.create')}}"><span class="fa fa-plus-circle">Effectuer une demande</span></a>
                                </li>
                                <li>
                                    <a href="{{route('demande.index')}}"><span class="fa fa-plus-circle">Liste des demandes</span></a>
                                </li>
                                <li>
                                    <a href="{{route('sortieStock.index')}}"><span class="fa fa-plus-circle">Sorties stock</span></a>
                                </li>
                                <li>
                                    <a href="{{route('stock.create')}}"><span class="fa fa-plus-circle">Sorties exceptionnelle</span></a>
                                </li>
                                <li>
                                    <a href="{{route('inventaire.index')}}"><span class="fa fa-plus-circle">Inventaires</span></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>PARAMETRES<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('societe.index')}}"><span class="fa fa-plus-circle">Societes</span></a>
                                </li>
                                <li>
                                    <a href="{{route('service.index')}}"><span class="fa fa-plus-circle">Services</span></a>
                                </li>
                                <li>
                                    <a href="{{route('compte.index')}}"><span class="fa fa-plus-circle">Comptes</span></a>
                                </li>
                                <li>
                                    <a href="{{route('role.index')}}"><span class="fa fa-plus-circle">Roles</span></a>
                                </li>
                                <li>
                                    <a href="{{route('utilisateur.index')}}"><span class="fa fa-plus-circle">Utilisateurs</span></a>
                                </li>
                                <li>
                                    <a href="{{route('menu.index')}}"><span class="fa fa-plus-circle">Menus</span></a>
                                </li>
                                <li>
                                    <a href="{{route('sousMenu.index')}}"><span class="fa fa-plus-circle">sousMenu</span></a>
                                </li>
                                <li>
                                    <a href="{{route('abilitation.index')}}"><span class="fa fa-plus-circle">Habilitation</span></a>
                                </li>
                                <li>
                                    <a href="{{route('superCategorie.index')}}"><span class="fa fa-plus-circle">Super Categorie Article</span></a>
                                </li>
                                <li>
                                    <a href="{{route('familleArticle.index')}}"><span class="fa fa-plus-circle">Familles Article</span></a>
                                </li>
                                <li>
                                    <a href="{{route('categorieFournisseur.index')}}"><span class="fa fa-plus-circle">Categories Fournisseur</span></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>Autres parametres<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="{{route('parametre.index')}}"><span class="fa fa-plus-circle">Mail du gestionnaire</span></a>
                                        </li>
                                        <li>
                                            <a href="{{route('message.index')}}"><span class="fa fa-plus-circle">Messages</span></a>
                                        </li>
                                        <li>
                                            <a href="{{route('motif.index')}}"><span class="fa fa-plus-circle">Motifs</span></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        @else
                            @foreach(menu() as $menu)
                                <li>
                                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>{{$menu->nomMenu}}<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        @foreach(habilitation() as $habilitation)
                                            @if($habilitation->menus_id == $menu->id)
                                                <li>
                                                    <a href="{{route($habilitation->lien)}}"><span class="fa fa-plus-circle">{{$habilitation->nomSousMenu}}</span></a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        @endif
                    @endif
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color: #0088CC">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <!-- /.dropdown -->
                @if(auth()->user())
                @if(auth()->user()->role=="gestionnaire")
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" style="background-color: #ffffff" href="#">
                            @if($valeur > 0)
                                <span class="badge" style="background-color: red;">
                        {{ $valeur > 0 ? $valeur : '' }}
                    </span>
                            @endif
                            <i class=""></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                @foreach($demandes as $demande)
                                    <li>
                                        <a href="{{route('demande.edit', $demande->id)}}">
                                            <div>
                                                <strong>{{$demande->nom}} {{$demande->prenom}} {{$demande->email}}</strong>
                                                <strong>{{$demande->dateDemande}}</strong>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                                </a>
                                </li>
                                <li class="divider"></li>
                        </ul>
                        <!-- /.dropdown-alerts -->
                    </li>
                @endif
                @endif
            <!-- /.dropdown -->
                <li class="dropdown" style="background-color: #ffffff">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-user">
                        @if(auth()->user())
                        <li>
                            <i class="fa fa-user fa-fw"></i> {{auth()->user()->nom}} {{auth()->user()->prenom}}
                        </li>
                        @endif
                        <li class="divider"></li>
                        <li><a href="{{route('logout')}}"><i class="fa fa-sign-out fa-fw"></i> Deconnexion</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- /#page-wrapper -->
        {{--<img src="images/images.jpg" alt="image d'accueil" width="225" height="225">--}}
        @yield('content')
    </div>
</div>
</div>
<div class="text-center">
    <?php $date = new DateTime()?>
    LANALA-ASSURANCES <br>tout droit reservé <?php echo $date->format('Y');?>

</div>
<!-- /#wrapper -->
<!-- Bootstrap Core JavaScript -->
<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{asset('vendor/metisMenu/metisMenu.min.js')}}"></script>

<!-- Morris Charts JavaScript -->
<script src="{{asset('ven


dor/raphael/raphael.min.js')}}"></script>
<script src="{{asset('vendor/morrisjs/morris.min.js')}}"></script>
<script src="{{asset('data/morris-data.js')}}"></script>
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{asset('vendor/metisMenu/metisMenu.min.js')}}"></script>

<!-- DataTables JavaScript -->
<script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('vendor/datatables-responsive/dataTables.responsive.js')}}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{asset('dist/js/sb-admin-2.js')}}"></script>
<script>
    $(document).ready(function() {
        $(document).ready(function () {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    });
</script>
@include('flashy::message')
</body>
</html>
