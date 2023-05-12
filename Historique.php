<?php
require_once("connect.php");
session_start();
$id_adherent = $_SESSION['id_adherent'];
$sql = "SELECT ouvrage.*, emprunt.date_d_emprunt, emprunt.date_de_retour
        FROM emprunt
        INNER JOIN ouvrage ON emprunt.Id_ouvrage = ouvrage.Id_ouvrage
        WHERE emprunt.Id_adherent = :id_adherent";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(':id_adherent' => $id_adherent));
$ouvrages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="Historique.css">
        <title>Document</title>
    </head>

    <body>
        <header>
            <div class="container">
                <img src="images/logo.png" width="100" height="100"> 
                <div class="logo">
                </div>
                <nav>
                    <ul>
                        <li><a href="ouvres.php">Ouvrages</a></li>
                        <li><a href="profil.php">Profil</a></li>
                        <li><a href="Historique.php">Historique</a></li>
                        <li><a href="Deconnexion.php">Déconnexion</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <h1 style="text-align: center;">Historique</h1>
        <div class="container">
        <?php if(count($ouvrages) == 0): ?>
        <p style="text-align:center; font-size: 50px; padding-top: 50px">Aucun ouvrage trouvé !</p>
    <?php else: ?>
    <?php foreach ($ouvrages as $key => $value): ?>
        <div class="book">
        <img src="images/<?php echo $value['Image_de_couverture']; ?>">
            <h3><?php echo $value['Titre'] ?></h3>
            <p><?php echo $value['Nom_d_auteur'] ?></p>
            <p><?php echo $value['Etat'] ?></p>
            <p><?php echo $value['Type'] ?></p>
            <a href="Details.php?id=<?php echo $value['Id_ouvrage']; ?>"> Plus de details...</a>
        </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>


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
