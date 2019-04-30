<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bon_de_commande_{{$codeCommande}}</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <img src="images/lanalaLogo.png">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row panel-heading col-md-offset-8 jumbotron-fluid text-center" >
                        BON DE PAYEMENT
                    </div>
                    <br>
                    <br>
                    <div class="row col-md-12 col-lg-12">
                        <div class="col col-md-offset-4 col-md-8">
                            <span>REFERENCE DE PAYEMENT : </span>
                            <span>{{$referencePayement}}</span>
                        </div>
                    </div>
                    <br>
                    <div class="row col-md-12 col-lg-12">
                        <div class="col col-md-offset-4 col-md-8">
                            <span>NUMERO COMMANDE : </span>
                            <span>{{$codeCommande}}</span>
                        </div>
                    </div>
                    <br>
                    <div class="row col-md-12 col-lg-12">
                        <div class="col-md-offset-4 col-md-3">
                            <span>DATE : </span>
                            <span>{{$datePayement}}</span>
                        </div>
                    </div>
                    <br>
                    <div class="row col-md-12 col-lg-12">
                        <div class="col-md-offset-4 col-md-12">
                            <span>FOURNISSEUR : </span>
                            <span>{{$nomSociete}} {{$nomContact}} {{$prenomContact}}</span>
                        </div>
                    </div>
                    <hr class="h3 panel-heading">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-md-offset-4">
                            <span class="col-md-offset-6">MONTANT TOTAL :    {{$montantPayer}}</span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <br>
                        <table class="table table-bordered border-table-hover text-center col_line">
                            <thead>
                            <tr class="grise col_line">
                                <th class="text-center col_line" colspan="2">VISAS:</th>
                            </tr>
                            <tr class="col_line">
                                <th class="text-center col_line">Signature et Cachet</th>
                                <th class="text-center col_line">Signature et Cachet</th>
                            </tr>
                            <tr class="col_line">
                                <th class="text-center col_line" height="80px"></th>
                                <th class="text-center col_line" height="80"></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
