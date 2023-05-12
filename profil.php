<?php
// on se connecte à la base
require_once("connect.php");
session_start();
echo $_SESSION['id_adherent'];
// Récupération des données de l'adhérent
$id_adherent = $_SESSION['id_adherent']; // replace with the actual id of the adherent
$requete = $pdo->prepare('SELECT * FROM adherent WHERE id_adherent = :id');
$requete->bindValue(':id', $id_adherent);
$requete->execute();
$adherent = $requete->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">
  <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="profil.css">
  <title>Document</title>
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
    </div>
  </header>





  <form>
    <div class="col-md-7 border-end" style="margin-left: 300px;">
      <div class="p-3 py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="text-right">Profil</h4>
        </div>

        <div class="row mt-4">
          <div class="col-md-6">
            <label class="labels">Nom</label>
            <input type="text" name="firstName" id="firstName" class="form-control" value="<?php echo $adherent['Nom']; ?>" required>
          </div>
          <div class="col-md-6">
            <label class="labels">Prenom</label>
            <input type="text" name="lastName" id="lastName" class="form-control" value="<?php echo $adherent['Prenom']; ?>" required>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-12">
            <label class="labels">Numéro de téléphone</label>
            <input type="number" id="phone" name="phone" class="form-control" value="<?php echo $adherent['Telephone']; ?>" required>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <label class="labels">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo $adherent['Email']; ?>" required>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <label class="labels">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" value="<?php echo $adherent['Mot_de_passe']; ?>" required>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-12">
            <label class="labels">CIN</label>
            <input type="text" class="form-control" value="<?php echo $adherent['CIN']; ?>" required>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-12">
            <label class="labels">Date de naissance</label>
            <input type="date" class="form-control" value="<?php echo $adherent['Date_de_naissance']; ?>" required>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-12">
            <label class="labels">Type</label>
            <input type="text" class="form-control" value="<?php echo $adherent['type']; ?>" required>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-12">
            <label class="labels">Date de création</label>
            <input type="text" class="form-control" value="<?php echo $adherent['Date_de_creation']; ?>" required>
          </div>
        </div>

      </div>

      <div class="mt-5 text-center">
        <input class="btn btn-primary profile-button" type="submit" value="Confirmer">
      </div>

    </div>
  </form>


  <footer>
    <div class="container">
      <div class="footer-col">
        <h3>À propos de nous</h3>
        <p>Nous sommes une bibliothèque dédiée à la promotion de la lecture et de l'éducation. Nous proposons
          une vaste collection de livres, physiques et numériques, pour les lecteurs de tous âges.</p>
      </div>
      <div class="footer-col">
        <h3>Liens</h3>
        <ul>
          <li><a href="#">Accueil</a></li>
          <li><a href="#">Ouvrages</a></li>
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