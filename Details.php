<?php
// on se connecte à la base
require_once("connect.php");

$id = $_GET["id"];

// prepare a SELECT query
$sql = "SELECT * FROM `ouvrage` WHERE Id_ouvrage = $id ";
$stmt = $pdo->prepare($sql);

// execute the query
$stmt->execute();

// fetch all the rows as an associative array
$ouvrages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Details.css">
    <title>Document</title>
</head>

<body>
    <header>
    <div class="logo">
            <img src="images/logo.png" width="100" height="80"> 
            </div>
        <nav>
            <ul>
                <li><a href="ouvres.php">Ouvrages</a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="Historique.php">Historique</a></li>
                <li><a href="#">Déconnection</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php foreach ($ouvrages as $ouvrage) : ?>
            <h2><?= $ouvrage['Titre'] ?></h2>
            <img src="images/<?php echo $ouvrage['Image_de_couverture']; ?>">
            <p>Auteur: <?= $ouvrage['Nom_d_auteur'] ?></p>
            <p>Etat: <?= $ouvrage['Etat'] ?></p>
            <p>Type: <?= $ouvrage['Type'] ?></p>
            <p>Nombre des pages: <?= $ouvrage['Nombre_des_pages'] ?></p>
            <p>Date d'édition: <?= $ouvrage['Date_d_edition'] ?></p>
            <p>Date d'achat: <?= $ouvrage['Date_d_achat'] ?></p>
            <button><a href="includes/reserve.php?id=<?php echo $ouvrage['Id_ouvrage'] ?>">reservé</a></button>
            <a href="ouvres.php"><button>annulé</button></a>
        <?php endforeach; ?>
    </main>
    <footer>
        <div class="container">
            <div class="footer-col">
                <h3>À propos de nous</h3>
                <p>Nous sommes une bibliothèque dédiée à la promotion de la lecture et de l'éducation. Nous proposons une vaste collection de livres, physiques et numériques, pour les lecteurs de tous âges.</p>
            </div>
            <div class="footer-col">
                <h3>Liens</h3>
                <ul>
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">Contactez-nous</a></li>
                    <li><a href="#">FAQs</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Réseaux sociaux</h3>
                <ul class="social-links">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2023 Library. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>