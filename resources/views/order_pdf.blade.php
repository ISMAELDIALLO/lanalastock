<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Impression</title>

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
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="panel-heading col-md-offset-4 jumbotron-fluid" >
                        BON DE COMMANDE LANALA_ASSURANCE
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-offset-3">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-0 col-md-3">
                            <span>NUMERO COMMANDE: </span>
                        </div>
                        <div class="col-md-offset-0 col-md-2">
                            <span>{{$codeCommande}}</span>
                        </div>
                        <div class="col-md-offset-1 col-md-1">
                            <span>DATE: </span>
                        </div>
                        <div class="col-md-offset-0 col-md-3">
                            <span>{{$dateCommande}}</span>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-offset-0 col-md-2">
                            <span>FOURNISSEUR</span>
                        </div>
                        <div class="col-md-offset-0 col-md-1">
                            <span>{{$fournisseur}}</span>
                        </div>
                    </div>
                    <hr class="h3 panel-heading">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ARTICLE</th>
                            <th>QUANTITE</th>
                            <th>PRIX UNITAIRE</th>
                            <th>MONTANT</th>
                        </tr>
                        </thead>
                        <tbody class="text-center col-md-offset-1">
                        <?php $i=0; ?>
                        @foreach($commandes as $commande)
                            <tr>
                                <td><?php $i++; echo $i;?></td>
                                <td>{{$commande->libelleArticle}}</td>
                                <td>{{$commande->quantite}}</td>
                                <td>{{$commande->dernierPrix}}</td>
                                <td>{{$commande->quantite*$commande->dernierPrix}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-3">
                            <span>MONTANT TOTAL</span>
                        </div>
                        <div class="col-md-offset-0 col-md-1">
                            <span>{{$montant}}</span>
                        </div>
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
