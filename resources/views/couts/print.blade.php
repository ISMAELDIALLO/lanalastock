<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

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
    <script language="javascript">
        function imprimer_bloc(couts, objet) {
// Définition de la zone à imprimer
            var zone = document.getElementById(objet).innerHTML;

// Ouverture du popup
            var fen = window.open("", "", "height=300, width=500,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=8, top=10");

// style du popup
            fen.document.body.style.color = '#000000';
            fen.document.body.style.backgroundColor = '#FFFFFF';
            fen.document.body.style.padding = "20px";

// Ajout des données a imprimer
            fen.document.title = couts;
            fen.document.body.innerHTML += " " + zone + " ";

// Impression du popup
            fen.window.print();

//Fermeture du popup
            fen.window.close();
            return true;
        }
    </script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body" id="imprime_moi" onclick="imprimer_bloc('couts','imprime_moi')">
                    <div class="panel-heading col-md-offset-4 jumbotron-fluid" >
                        COUTS PAR SERVICE
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-offset-3">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-0 col-md-3">
                            <span>ENTRE LE: </span>
                        </div>
                        <div class="col-md-offset-0 col-md-2">
                            <span>{{session('dateDebut')}}</span>
                        </div>
                        <div class="col-md-offset-1 col-md-2">
                            <span>ET LE: </span>
                        </div>
                        <div class="col-md-offset-0 col-md-3">
                            <span>{{session('dateFin')}}</span>
                        </div>
                    </div>
                    <hr class="h3 panel-heading">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>SERVICE</th>
                            <th>COUTS VIE</th>
                            <th>COUTS IARD</th>
                            <th>MONTANT</th>
                        </tr>
                        </thead>
                        <tbody class="text-center col-md-offset-1">
                        <?php $i=0; ?>
                        @foreach($couts as $cout)
                            <tr>
                                <td><?php $i++; echo $i;?></td>
                                <td>{{$cout->service}}-{{$cout->nomSociete}}</td>
                                <td>{{$cout->cout*$cout->pourcentage_vie/100}}</td>
                                <td>{{$cout->cout*$cout->pourcentage/100}}</td>
                                <td>
                                    {{($cout->cout*$cout->pourcentage_vie/100)+($cout->cout*$cout->pourcentage/100)}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
