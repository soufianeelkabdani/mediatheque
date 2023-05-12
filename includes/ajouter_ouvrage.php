<?php
require_once('../connect.php');
session_start();

if (isset($_POST['submit'])) {
    // Récupération des données du formulaire
    $titre = $_POST['Titre'] ?? '';
    $type = $_POST['Type'] ?? '';
    $nom_auteur = $_POST['Nom_d_auteur'] ?? '';
    $image_couverture = $_FILES['file'];
    $etat = $_POST['Etat'] ?? '';
    $nombre_pages = $_POST['Nombre_des_pages'] ?? '';
    $date_edition = $_POST['Date_d_edition'] ?? '';
    $date_achat = $_POST['Date_d_achat'] ?? '';

    $imagefilename = $image_couverture['name'];
    $imagefileerror = $image_couverture['error'];
    $imagefiletemp = $image_couverture['tmp_name'];
    $filename_separate = explode('.', $imagefilename);
    $file_extension = strtolower(end($filename_separate));

    $extension = array('jpeg', 'jpg', 'png');
    if (in_array($file_extension, $extension)) {
        if(move_uploaded_file($imagefiletemp, '../images/' . $imagefilename)){
            $stmt = $pdo->prepare("INSERT INTO ouvrage (Titre, Type, Nom_d_auteur, Image_de_couverture, Etat, Nombre_des_pages, Date_d_edition, Date_d_achat) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $titre);
            $stmt->bindParam(2, $type);
            $stmt->bindParam(3, $nom_auteur);
            $stmt->bindParam(4, $imagefilename);
            $stmt->bindParam(5, $etat);
            $stmt->bindParam(6, $nombre_pages);
            $stmt->bindParam(7, $date_edition);
            $stmt->bindParam(8, $date_achat);
            $result = $stmt->execute();
            if ($result) {
                // Redirection vers admin.php après l'ajout réussi
                header('Location: ../admin.php');
                exit();
            } else {
                die($pdo->errorInfo()[2]);
            }
        }else{
            echo "Erreur lors du téléchargement du fichier.";
        }
    }else{
        echo "Le format de l'image doit être jpeg, jpg ou png.";
    }
}
?>