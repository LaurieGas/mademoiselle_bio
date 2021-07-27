<?php

require_once "config/config_bdd.php";

if ((isset($_GET['id_etablissement'])) && !empty($_GET['id_etablissement'])) {
  $id_etablissement = htmlentities($_GET['id_etablissement']);
 
// ==============================================
    //ETAPE 1 : CONNEXION A LA BDD
// ==============================================
    try {
        //Options PDO de connexion
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $bdd = new PDO('mysql:host=' . HOST . ';dbname=' . DB_NAME . ';charset=utf8', USER, PWD, $options);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
// ==============================================
    //ETAPE 2 : REQUETES
// ==============================================

    // requete pour recup les infos des classes
    $requeteSelectAll = $bdd->query("SELECT id_classe, code, nom FROM classe");
  
    // requete pour recup le nbre total d'élèves dans l'établissement
     $requeteTotalEleves = $bdd->query("SELECT COUNT(id_eleves) FROM eleves");

// ======================================================
    // ETAPE 3 : PARCOURS ET AFFICHAGE DES DONNEES
// ======================================================

    $classes = $requeteSelectAll->fetchAll(PDO::FETCH_ASSOC);
    $totalEleves = $requeteTotalEleves->fetchAll(PDO::FETCH_ASSOC);

    // echo "<pre>";
    // print_r($totalEleves);
    // echo "</pre>";

} else {
    header("location:index.php");
}

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
        <h1>Liste des classes</h1>
        <br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Code</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Enseignants</th>
                    <th scope="col">Elèves</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($classes as $classe) { /* while($contact = $requeteSelectAll ->fetch()) { */
                ?>
                    <tr>
                        <th scope="row"><?= strtoupper($classe['id_classe']) ?></th>
                        <td><?= strtoupper($classe['code']) ?></td>
                        <td><?= strtoupper($classe['nom']) ?></td>
                        <td><a href="enseignants_classe.php?id_classe=<?=$classe['id_classe']?>" class="btn btn-secondary btn-sm">Enseignants</a></td>
                        <td><a href="eleves.php?id_classe=<?=$classe['id_classe']?>" class="btn btn-secondary btn-sm">Elèves</a></td>
                 <?php } ?>
            </tbody>
            </table>
        <br>
        <div class="alert alert-secondary" role="alert">
        <?php foreach ($totalEleves as $eleve) { ?>
            <p>Nombre d'élèves dans l'établissement : <?=($eleve['COUNT(id_eleves)']); ?></p>
        <?php } ?>
        </div>
        <br>
        <p class="lead">
            <a class="btn btn-secondary btn-lg" href="index.php" role="button">Retour accueil</a>
        </p>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>