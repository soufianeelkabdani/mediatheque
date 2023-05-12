<?php
require_once("connect.php");

$per_page = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if(isset($_GET['q'])) {
    $search = $_GET['q'];
    $query = "SELECT COUNT(*) as total FROM ouvrage WHERE Titre LIKE :search OR Nom_d_auteur LIKE :search";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_items = $result['total'];

    // Search 
    $query = "SELECT * FROM ouvrage WHERE Status = :statu AND  Titre LIKE :search OR Nom_d_auteur LIKE :search ORDER BY Titre LIMIT :offset, :per_page";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':statu', $status);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->bindValue(':offset', ($page - 1) * $per_page, PDO::PARAM_INT);
    $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->execute();
    $ouvrages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $query = "SELECT COUNT(*) as total FROM ouvrage";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_items = $result['total'];

    $status = 'Disponible';
    $query = "SELECT * FROM ouvrage WHERE Status = :statu ORDER BY Titre LIMIT :offset, :per_page";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':statu', $status);
    $stmt->bindValue(':offset', ($page - 1) * $per_page, PDO::PARAM_INT);
    $stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    $stmt->execute();
    $ouvrages = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$total_pages = ceil($total_items / $per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ouvres.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <title>Ouvres</title>
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">
            <img src="images/logo.png" width="100" height="100"> 
            </div>
            <nav>
                <ul>
                    <li><a href="ouvres.php">Ouvrages</a></li>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="Historique.php">Historique</a></li>
                    <li><a href="Deconnexion.php">Déconnexion</a></li>
                </ul>
            </nav>
            <form class="search-form" method="get">
            <input type="text" placeholder="Search..." name="q">
             <button type="submit">Recherche</button>
            </form>
        </div>
    </header>
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <a href="?page=<?php echo $i; ?><?php if(isset($_GET['q'])) { echo '&q=' . $_GET['q']; } ?>"<?php if ($page == $i) { echo ' class="active"'; } ?>><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>

    <main>
        <div class="container">
            <h1>BIENVENUE!</h1>
            <p>Une médiathèque publique, également appelée bibliothèque municipale ou bibliothèque communautaire, est une institution accessible au public qui offre une variété de ressources et de services à ses usagers. Ces ressources comprennent généralement des livres, des magazines, des journaux, des livres audio, des livres électroniques, des DVD et des CD. La bibliothèque donne également accès à des ordinateurs et à Internet à des fins de recherche, éducatives et récréatives.</p>
        </div>
    </main>
    <h1 style="text-align: center;">Liste des ouvrages</h1>
<div class="container">
    <?php foreach ($ouvrages as $key => $value) : ?>
        <div class="book">
        <img src="images/<?php echo $value['Image_de_couverture']; ?>">
            <h3><?php echo $value['Titre'] ?></h3>
            <p><?php echo $value['Nom_d_auteur'] ?></p>
            <p><?php echo $value['Etat'] ?></p>
            <p><?php echo $value['Type'] ?></p>
            <p><?php echo $value['Status'] ?></p>
            <a href="Details.php?id=<?php echo $value['Id_ouvrage']; ?>"> Plus de details...</a>
        </div>
    <?php endforeach; ?>
</div>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1) : ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $current_page - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <?php if ($i == $page) : ?>
                <li class="page-item active"><a class="page-link" href="#"><?php echo $i ?></a></li>
            <?php else : ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $total_pages) : ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $current_page + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
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