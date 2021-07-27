<?php 

require_once "config/config_bdd.php";

if(isset($_GET['id_etablissement']) && !empty($_GET['id_etablissement'])) {
    $id_etablissement = htmlentities($_GET['id_etablissement']);
    
    // =================================================
    // ETAPE 1 : CONNEXION A LA BDD
    // =================================================

    try {
        //Options PDO de connexion
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $bdd = new PDO('mysql:host='.HOST.';dbname='.DB_NAME.';charset=utf8', USER, PWD, $options);
    }
    catch(Exception $e) {
        echo $e->getMessage();
        die();
    }

    // ============================================
    // ETAPE 2 : REQUETES
    // ===========================================

    // recup l'id d'un etablissement
        $reqSelectById = $bdd->prepare("SELECT * FROM etablissement WHERE id_etablissement = ?"); // un prepare car info envoyé par un GET via URL, on se protège des injections sql
        $reqSelectById-> execute([$id_etablissement]);

    // requete pour recup les infos des enseignants
    $requeteSelectAll = $bdd->query("SELECT nom, prenom, telephone FROM enseignants");

    // =================================================
    // ETAPE 3 : PARCOURIR ET AFFICHER LES DONNEES
    // =================================================

    // ici on utilise fetch car on veut recup un seul resultat
    $etablissements = $reqSelectById->fetch(PDO::FETCH_ASSOC); 

    //  petite vérif
        // echo "<pre>";
        // print_r($enseignants);
        // echo "</pre>";

    $enseignants = $requeteSelectAll->fetchAll(PDO::FETCH_ASSOC);
                                    
}
else {
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
    <h1>Liste des enseignants</h1>
    <br>

        <!-- Jumbotron -->
    <div class="jumbotron">
    <h1 class="display-4">Ecole Dalembert</h1>
    <p class="lead"> 
    <?php foreach($enseignants as $enseignant) { /* while($contact = $requeteSelectAll ->fetch()) { */
                ?> 
    Nom : <?php echo $enseignant['nom'];?><br>
    Prenom : <?php echo $enseignant['prenom'];?><br>
    Téléphone : <?php echo $enseignant['telephone'];?>
    </p>
    <?php } ?>
    <hr class="my-4">
    <p class="lead"><a class="btn btn-secondary btn-lg" href="index.php" role="button">Retour accueil</a></p>
    </div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>