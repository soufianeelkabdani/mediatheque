<?php
require_once('connect.php');
$sql = 'SELECT * FROM `emprunt` as e JOIN `ouvrage` as o ON e.Id_ouvrage = o.Id_ouvrage JOIN `adherent` as a ON e.Id_adherent = a.Id_adherent and e.Status = "emprunté";';
$stmt = $pdo->prepare($sql);
try {
    $stmt->execute();
    $emprunts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="emprunt-admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <title>My Website</title>
</head>

<body>
<header>
    <nav class="menu-navigation">
        <ul id="menu">
            <li><a href="admin.php">Accueil</a></li>
            <li><a href="reservation-admin.php">Réservation</a></li>
            <li><a href="emprunt-admin.php">Emprunt</a></li>
            <li><a href="Deconnexion.php">Déconnexion</a></li>
        </ul>
    </nav>
    <div>
        <a href="admin.php"><img src="images/logo.png" width="100" height="100"></a>
    </div>
</header>

    <h1 style="text-align: center;"> Ouvrages</h1>


    <div class="container">
    <?php if(count($emprunts) == 0): ?>
        <p style="text-align:center; font-size: 50px; padding-top: 90px">Aucun emprunt trouvé !</p>
    <?php else: ?>
        <?php
        foreach ($emprunts as $key => $value) :
        ?>
            <div class="book">
            <img src="images/<?php echo $value['Image_de_couverture']; ?>">
                <h3><?php echo $value['Titre'] ?></h3>
                <p>Author:<?php echo $value['Nom_d_auteur'] ?></p>
                <p>Client: <?php echo $value['Surname'] ?></p>
                <p><?php echo $value['Type'] ?></p>
                <button class="confirmer-button"><a href="includes/confirm_emprunt_return.php?id=<?php echo $value['Id_emprunt'] ?>">Confirmer</a></button>
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