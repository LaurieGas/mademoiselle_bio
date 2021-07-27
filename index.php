<?php 

require_once "config/config_bdd.php";

// ========================================================
// ETAPE 1 : CONNEXION
// ========================================================

try {
    //Options PDO de connexion
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $bdd = new PDO('mysql:host='.HOST.';dbname='.DB_NAME.';charset=utf8', USER, PWD, $options);
}
catch(Exception $e) {
    echo $e->getMessage();
    die();
}

// var_dump($bdd); // vérif que la connexion à la bdd est effective

// ==================================================================
// ETAPE 2 : REQUETE : recuperer toutes les données tout les contacts
// ==================================================================

$requeteSelectAll = $bdd->query("SELECT * FROM etablissement");
$requeteSelect= $bdd->query("SELECT nom FROM directeur");

// ========================================================
// ETAPE 3 : PARCOURS ET AFFICHAGE DES DONNEES
// ========================================================

$etablissements = $requeteSelectAll->fetchAll(PDO::FETCH_ASSOC);
// print_r($etablissements)
$directeurs = $requeteSelect->fetchAll(PDO::FETCH_ASSOC);

?>


<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Ecole Dalembert</title>
  </head>
  <body>
    <!-- NavBar -->
   <?php include "include/navbar.php";?>

    <div class="container">
        <br>
        <h1>Bienvenue !<h1>
        <br>    
        <h3>Liste des établissements</h3>
        <br>
            <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th> 
                <th scope="col">Nom</th>
                <th scope="col">Directeur</th>
                <th scope="col">Numéro de rue</th>
                <th scope="col">Adresse</th>
                <th scope="col">Ville</th>
                <th scope="col">Enseignants</th>
                <th scope="col">Classes</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($etablissements as $etablissement) {
                ?> 
                <tr>
                    <th scope="row"><?= $etablissement['id_etablissement']; ?></th>
                    <td><?= strtoupper($etablissement['nom'])?></td>
                    <?php foreach($directeurs as $directeur){ ?>
                    <td><?= $directeur['nom']; ?></td>
                    <?php } ?>
                    <td><?= $etablissement['num_rue']; ?></td>
                    <td><?= $etablissement['adresse']; ?></td>
                    <td><?= strtoupper($etablissement['ville']); ?></td>
                    <td><a href="enseignants.php?id_etablissement=<?=$etablissement['id_etablissement'];?>" class="btn btn-secondary btn-sm">Enseignants</a></td>
                    <td><a href="classes.php?id_etablissement=<?=$etablissement['id_etablissement'];?>" class="btn btn-secondary btn-sm">Classes</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
