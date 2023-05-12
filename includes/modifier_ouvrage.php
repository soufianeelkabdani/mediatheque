<?php
require_once('../connect.php');
session_start();

if (isset($_POST['submit'])) {
    // Récupération des données du formulaire
    $id = $_POST['id_modifier'] ?? '';
    $titre = $_POST['Titre'] ?? '';
    $type = $_POST['Type'] ?? '';
    $nom_auteur = $_POST['Nom_d_auteur'] ?? '';
    $etat = $_POST['Etat'] ?? '';
    $nombre_pages = $_POST['Nombre_des_pages'] ?? '';
    $date_edition = $_POST['Date_d_edition'] ?? '';
    $date_achat = $_POST['Date_d_achat'] ?? '';
    
    $stmt = $pdo->prepare("SELECT Image_de_couverture FROM ouvrage WHERE id_ouvrage = ?");
    $stmt->execute([$id]);
    $old_image = $stmt->fetchColumn();

    // Vérifier si une nouvelle image a été téléchargée
    if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
        $imagefilename = $_FILES['file']['name'];
        $imagefiletemp = $_FILES['file']['tmp_name'];
        $filename_separate = explode('.', $imagefilename);
        $file_extension = strtolower(end($filename_separate));

        $extension = array('jpeg', 'jpg', 'png');
        if (in_array($file_extension, $extension)) {
            if(move_uploaded_file($imagefiletemp, '../images/' . $imagefilename)){
                // Supprimer l'ancienne image de couverture
                if($old_image && file_exists("../images/$old_image")){
                    unlink("../images/$old_image");
                }
                $stmt = $pdo->prepare("UPDATE ouvrage SET Titre = ?, Type = ?, Nom_d_auteur = ?, Image_de_couverture = ?, Etat = ?, Nombre_des_pages = ?, Date_d_edition = ?, Date_d_achat = ? WHERE id = ?");
                $stmt->bindParam(1, $titre);
                $stmt->bindParam(2, $type);
                $stmt->bindParam(3, $nom_auteur);
                $stmt->bindParam(4, $imagefilename);
                $stmt->bindParam(5, $etat);
                $stmt->bindParam(6, $nombre_pages);
                $stmt->bindParam(7, $date_edition);
                $stmt->bindParam(8, $date_achat);
                $stmt->bindParam(9, $id);
            }else{
                echo "Erreur lors du téléchargement du fichier.";
                exit();
            }
        }else{
            echo "Le format de l'image doit être jpeg, jpg ou png.";
            exit();
        }
    }else{
        $stmt = $pdo->prepare("UPDATE ouvrage SET Titre = ?, Type = ?, Nom_d_auteur = ?, Etat = ?, Nombre_des_pages = ?, Date_d_edition = ?, Date_d_achat = ? WHERE Id_ouvrage = ?");
        $stmt->bindParam(1, $titre);
        $stmt->bindParam(2, $type);
        $stmt->bindParam(3, $nom_auteur);
        $stmt->bindParam(4, $etat);
        $stmt->bindParam(5, $nombre_pages);
        $stmt->bindParam(6, $date_edition);
        $stmt->bindParam(7, $date_achat);
        $stmt->bindParam(8, $id);
    }
    
    $result = $stmt->execute();
    if ($result) {
        // Redirection vers admin.php après l'ajout réussi
        header('Location: ../admin.php');
        exit();
    }
}
?>