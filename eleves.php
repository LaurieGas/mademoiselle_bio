<?php

require_once "config/config_bdd.php";

if (isset($_GET['id_classe']) && !empty($_GET['id_classe']) ) {
    $id_classe = htmlentities($_GET['id_classe']);
   
// ==================================================
    // ETAPE 1 : CONNEXION A LA BDD
// ==================================================

    try {
        //Options PDO de connexion
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $bdd = new PDO('mysql:host=' . HOST . ';dbname=' . DB_NAME . ';charset=utf8', USER, PWD, $options);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();

    }
// ===================================================
   // ETAPE 2 : REQUETES
// ===================================================

    // recup l'id d'une classe
    $reqSelectById = $bdd->prepare("SELECT * FROM classe WHERE id_classe = ?"); // un prepare car info envoyé par un GET via URL, on se protège des injections sql
    $reqSelectById->execute([$id_classe]);

    // requete pour recup les infos des eleves en fonction de leur id
    $requeteSelectEleves = $bdd->prepare("SELECT * FROM eleves WHERE id_classe = ?");
    $requeteSelectEleves->execute([$id_classe]);

    // requete pour recup le nbre d'eleves par classe
    $requeteCompteEleves = $bdd->prepare("SELECT COUNT(id_eleves) FROM eleves WHERE id_classe = ?");
    $requeteCompteEleves->execute([$id_classe]);

    

// ======================================================
    // ETAPE 3 : PARCOURS ET AFFICHAGE DES DONNEES
// ======================================================

    $classes = $reqSelectById->fetchAll(PDO::FETCH_ASSOC);
   
    $eleves = $requeteSelectEleves->fetchAll(PDO::FETCH_ASSOC);

    $compteEleves = $requeteCompteEleves->fetchAll(PDO::FETCH_ASSOC);

// petite vérif 
    // echo "<pre>";
    // var_dump($compteEleves);
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
    <?php include "include/navbar.php"; /* inclure la navbar qui est dans un fichier à part */ ?>


<div class="container">
        <br>
        <h1>Liste des élèves</h1>
        <br>
        <br>
        <br>
            <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th> 
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Numéro de rue</th>
                <th scope="col">Adresse</th>
                <th scope="col">Ville</th>
                <th scope="col">Téléphone</th>
                <th scope="col">Date de naissance</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($eleves as $eleve) { /* while($contact = $requeteSelectAll ->fetch()) { */
                ?> 
                <tr>
                    <th scope="row"><?= $eleve['id_eleves']; ?></th>
                    <td><?= strtoupper($eleve['nom'])?></td>
                    <td><?= $eleve['prenom']; ?></td>
                    <td><?= $eleve['num_rue']; ?></td>
                    <td><?= $eleve['adresse']; ?></td>
                    <td><?= strtoupper($eleve['ville']); ?></td>
                    <td><?= strtoupper($eleve['telephone']); ?></td>
                    <td><?= strtoupper($eleve['date_naissance']); ?></td>
            <?php } ?>
                </tr>
            </tbody>
        </table>
        <br>
        <div class="alert alert-secondary" role="alert">
        <?php foreach ($compteEleves as $eleve) { ?>
            <p>Total élèves par classe : <?=($eleve['COUNT(id_eleves)']); ?></p>
        <?php } ?>
        </div>
        <br>
        <p><a href="index.php" class="btn btn-secondary btn-lg">Retour accueil</a></p>
                
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>