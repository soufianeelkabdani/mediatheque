<?php
require_once('connect.php');
session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] === 1) {

    // set the number of results per page
    $results_per_page = 6;

    // get the total number of ouvrages
    $query = "SELECT COUNT(*) as count FROM ouvrage";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_results = $row['count'];

    // calculate the total number of pages
    $total_pages = ceil($total_results / $results_per_page);

    // get the current page number
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $current_page = (int) $_GET['page'];
    } else {
        $current_page = 1;
    }

    // calculate the offset for the query
    $offset = ($current_page - 1) * $results_per_page;

    // prepare a SELECT query with pagination
    $query = "SELECT * FROM ouvrage LIMIT :offset, :results_per_page";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
    $stmt->execute();

    // fetch all the rows as an associative array
    $ouvrages = $stmt->fetchAll(PDO::FETCH_ASSOC);

} 
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.1.96/css/materialdesignicons.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/eab43b8525.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-JWiO1A7NlOoA0Q7LfrH6PyuDJiV1XW/8h6MGRhpSIe4ALRvubU6i05U6fjBB6T0S" crossorigin="anonymous"></script>

        <title>admin</title>
    </head>

    <body>
        <header>
        <img src="images/logo.png" width="100" height="100"> 
            <nav>
                <ul>
                    <li><a href="admin.php">Accueil</a></li>
                    <li><a href="reservation-admin.php">Réservation</a></li>
                    <li><a href="emprunt-admin.php">Emprunt</a></li>
                    <li><a href="Deconnexion.php">Déconnexion</a></li>
                </ul>
            </nav>
            <button type="button" class="btn btn-primary add-product-button" data-toggle="modal" data-target="#modalAjouter">Ajouter un ouvrage</button>
        </header>

        <h1 style="text-align: center;"> Les ouvrages</h1>


     
<div class="container">
    <?php foreach ($ouvrages as $key => $value) : ?>
        <div class="book">
        <img src="images/<?php echo $value['Image_de_couverture']; ?>">
            <h3><?php echo $value['Titre'] ?></h3>
            <p><?php echo $value['Nom_d_auteur'] ?></p>
            <p><?php echo $value['Etat'] ?></p>
            <p><?php echo $value['Type'] ?></p>
            <p><?= $value['Nombre_des_pages'] ?></p>
            <p><?= $value['Date_d_edition'] ?></p>
            <p><?= $value['Date_d_achat'] ?></p>
            <button type="button" class="btn btn-primary" style="margin-top: 10px;" data-toggle="modal" data-target="#ModalModifier<?php echo $value['Id_ouvrage'] ?>">Modifier </button>
            <button type="button" class="btn btn-danger" style="margin-top: 5px;" data-bs-toggle="modal" data-bs-target="#modalSupprimer<?php echo $value['Id_ouvrage'] ?>">Supprimer</button>            
        </div>

        <!-- Modals -->

        
 <!-------------------------------------Modifier un ouvrage -------------------------------- -->
<div class="modal fade" id="ModalModifier<?php echo $value['Id_ouvrage'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Modifier l'ouvrage</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" action="./includes/modifier_ouvrage.php">
          <input type="hidden" name="id_modifier" class="form-control" value="<?php echo $value['Id_ouvrage'] ?>">
          <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" name="Titre" class="form-control" value="<?php echo $value['Titre'] ?>">
          </div>
          <div class="form-group">
            <label for="auteur">Nom d'auteur :</label>
            <input type="text" name="Nom_d_auteur" class="form-control" value="<?php echo $value['Nom_d_auteur'] ?>">
          </div>
          <div class="form-group">
            <label for="image">Image :</label>
            <input type="file" name="file" id="image_couverture" class="form-control-file">
          </div>
          <div class="form-group">
            <label for="ouvrage_etat">Etat</label>
            <select name="Etat" id="ouvrage_etat" class="form-control">
              <option value="Neuf">Neuf</option>
              <option value="bon assez">bon assez</option>
              <option value="bon">bon</option>
            </select>
          </div>
          <div class="form-group">
            <label for="pages">Nombre de pages :</label>
            <input type="number" name="Nombre_des_pages" class="form-control" value="<?php echo $value['Nombre_des_pages'] ?>">
          </div>
          <div class="form-group">
            <label for="dateAchat">Date d'achat :</label>
            <input type="date" name="Date_d_achat" class="form-control" id="Date_d_achat" value="<?php echo $value['Date_d_achat'] ?>">
          </div>
          <div class="form-group">
            <label for="dateEdition">Date d'édition :</label>
            <input type="date" name="Date_d_edition" class="form-control" id="Date_d_edition" value="<?php echo $value['Date_d_edition'] ?>">
          </div>
          <div class="form-group">
            <label for="ouvrage_type">Type</label>
            <select name="Type" id="ouvrage_type" class="form-control">
              <option value="Livre">Livre</option>
              <option value="CD">CD</option>
              <option value="DVD">DVD</option>
              <option value="Roman">Roman</option>
              <option value="Magazine">Magazine</option>
            </select>
          </div>
      </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary" name="submit">Enregistrer les modifications</button>
            </div>
        </form>
      </div>
    </div>
  </div>
 <!-------------------------------------Supprimer un ouvrage -------------------------------- -->
<!-- Supprimer un ouvrage Modal -->
<div class="modal fade" id="modalSupprimer<?php echo $value['Id_ouvrage'] ?>" tabindex="-1" aria-labelledby="modalSupprimer<?php echo $value['Id_ouvrage'] ?>Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="supprimer_ouvrage.php" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalSupprimer<?php echo $value['Id_ouvrage'] ?>Label">Supprimer l'ouvrage</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" value="<?php echo $value['Id_ouvrage'] ?>">
          Êtes-vous sûr de vouloir supprimer cet ouvrage ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-danger" >Supprimer</button>
        </div>
      </form>
    </div>
  </div>
</div>

        <?php endforeach; ?>
    </div>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($current_page > 1) : ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $current_page - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <?php if ($i == $current_page) : ?>
                <li class="page-item active"><a class="page-link" href="#"><?php echo $i ?></a></li>
            <?php else : ?>
                <li class="page-item"><a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages) : ?>
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

          <!-------------------------------------Ajouter un ouvrage ----------------------------------->
          <div class="modal fade" id="modalAjouter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un ouvrage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" class="modal-body" enctype="multipart/form-data" action="./includes/ajouter_ouvrage.php">
                <input type="hidden" name="id_ajouter" class="form-control">
                <div class="mb-3">
                    <label for="" class="form-label">Titre</label>
                    <input type="text" name="Titre" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nom d'auteur</label>
                    <input type="text" name="Nom_d_auteur" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="cover_image" class="form-label">Image:</label>
                    <input type="file" name="file" id="image_couverture" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="ouvrage_etat" class="form-label">Etat</label>
                    <select name="Etat" id="ouvrage_etat" class="form-select">
                        <option value="Neuf">Neuf</option>
                        <option value="bon assez">bon assez</option>
                        <option value="bon">bon</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Nombre des pages</label>
                    <input type="nombre" name="Nombre_des_pages" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="Buy_Date_add" class="form-label">Date d'achat</label>
                    <input type="date" name="Date_d_achat" class="form-control" id="Date_d_achat">
                </div>
                <div class="mb-3">
                    <label for="Edition_Date_add" class="form-label">Date d'édition</label>
                    <input type="date" name="Date_d_edition" class="form-control" id="Date_d_edition">
                </div>
                <div class="mb-3">
                    <label for="ouvrage_type" class="form-label">Type</label>
                    <select name="Type" id="ouvrage_type" class="form-select">
                        <option value="Livre">Livre</option>
                        <option value="CD">CD</option>
                        <option value="DVD">DVD</option>
                        <option value="Roman">Roman</option>
                        <option value="Magazine">Magazine</option>
                    </select>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary" name="submit">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

 <!-------------------------------------Modifier un ouvrage -------------------------------- -->
<div class="modal fade" id="ModalModifier<?php echo $value['Id_ouvrage'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Modifier l'ouvrage</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" action="./includes/modifier_ouvrage.php">
          <input type="hidden" name="id_modifier" class="form-control" value="<?php echo $value['Id_ouvrage'] ?>">
          <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" name="Titre" class="form-control" value="<?php echo $value['Titre'] ?>">
          </div>
          <div class="form-group">
            <label for="auteur">Nom d'auteur :</label>
            <input type="text" name="Nom_d_auteur" class="form-control" value="<?php echo $value['Nom_d_auteur'] ?>">
          </div>
          <div class="form-group">
            <label for="image">Image :</label>
            <input type="file" name="file" id="image_couverture" class="form-control-file">
          </div>
          <div class="form-group">
            <label for="ouvrage_etat">Etat</label>
            <select name="Etat" id="ouvrage_etat" class="form-control">
              <option value="Neuf">Neuf</option>
              <option value="bon assez">bon assez</option>
              <option value="bon">bon</option>
            </select>
          </div>
          <div class="form-group">
            <label for="pages">Nombre de pages :</label>
            <input type="number" name="Nombre_des_pages" class="form-control" value="<?php echo $value['Nombre_des_pages'] ?>">
          </div>
          <div class="form-group">
            <label for="dateAchat">Date d'achat :</label>
            <input type="date" name="Date_d_achat" class="form-control" id="Date_d_achat" value="<?php echo $value['Date_d_achat'] ?>">
          </div>
          <div class="form-group">
            <label for="dateEdition">Date d'édition :</label>
            <input type="date" name="Date_d_edition" class="form-control" id="Date_d_edition" value="<?php echo $value['Date_d_edition'] ?>">
          </div>
          <div class="form-group">
            <label for="ouvrage_type">Type</label>
            <select name="Type" id="ouvrage_type" class="form-control">
              <option value="Livre">Livre</option>
              <option value="CD">CD</option>
              <option value="DVD">DVD</option>
              <option value="Roman">Roman</option>
              <option value="Magazine">Magazine</option>
            </select>
          </div>
      </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary" name="submit">Enregistrer les modifications</button>
            </div>
        </form>
      </div>
    </div>
  </div>
 <!-------------------------------------Supprimer un ouvrage -------------------------------- -->
<!-- Supprimer un ouvrage Modal -->
<div class="modal fade" id="modalSupprimer<?php echo $value['Id_ouvrage'] ?>" tabindex="-1" aria-labelledby="modalSupprimer<?php echo $value['Id_ouvrage'] ?>Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="supprimer_ouvrage.php" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="modalSupprimer<?php echo $value['Id_ouvrage'] ?>Label">Supprimer l'ouvrage</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" value="<?php echo $value['Id_ouvrage'] ?>">
          Êtes-vous sûr de vouloir supprimer cet ouvrage ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-danger" >Supprimer</button>
        </div>
      </form>
    </div>
  </div>
</div>
















    </body>

    </html>
 
