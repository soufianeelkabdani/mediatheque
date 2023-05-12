<?php
require_once('../connect.php');
$id = $_GET['id'];

// Prepare SQL statement to update the timestamp column
$sql = 'UPDATE emprunt SET date_de_retour = :date_de_retour WHERE Id_emprunt = :id';
$stmt = $pdo->prepare($sql);

// Bind the current date and time to the placeholder
$current_date = date("Y-m-d H:i:s");
$stmt->bindParam(':date_de_retour', $current_date);

// Bind the ID of the row to update
$stmt->bindParam(':id', $id);

// Execute the SQL statement
try {
    $stmt->execute();
    
    // Get the emprunt row that was just updated
    $emprunt_stmt = $pdo->prepare("SELECT * FROM emprunt as e JOIN ouvrage as o WHERE e.Id_ouvrage = o.Id_ouvrage AND e.Id_emprunt = :id");
    $emprunt_stmt->bindParam(':id', $id);
    $emprunt_stmt->execute();
    $emprunt = $emprunt_stmt->fetch(PDO::FETCH_ASSOC);
    
    // Change the status of the emprunt
    $status_stmt = $pdo->prepare("UPDATE emprunt SET Status = :statu WHERE Id_emprunt = :id");
    $status_stmt->bindParam(':id', $id);
    $status = 'retourné';
    $status_stmt->bindParam(':statu', $status);
    $status_stmt->execute();


    // Get the adherent row corresponding to the emprunt
    $adherent_stmt = $pdo->prepare("SELECT * FROM adherent WHERE Id_adherent = :id_adherent");
    $adherent_stmt->bindParam(':id_adherent', $emprunt['Id_adherent']);
    $adherent_stmt->execute();
    $adherent = $adherent_stmt->fetch(PDO::FETCH_ASSOC);

    // Update status of ouvrage
    $ouvrage_stmt = $pdo->prepare("UPDATE ouvrage SET Status = :statu WHERE Id_ouvrage = :Id_ouvrage");
    $statu = 'Disponible';
    $ouvrage_stmt->bindParam(':statu', $statu);
    $ouvrage_stmt->bindParam(':Id_ouvrage', $emprunt['Id_ouvrage']);
    $ouvrage_stmt->execute();

    
    
    // Calculate the difference between the current date and the expected return date
    $date_de_retour = new DateTime($emprunt['date_de_retour']);
    $date_d_emprunt = new DateTime($emprunt['date_d_emprunt']);
    $diff = $date_d_emprunt->diff($date_de_retour);
    $diff_jours = $diff->days;
    
    // If the book was returned after 15 days or more, increment the "Nombre_de_pénalité" column in the adherent table
    if ($diff_jours > 15) {
        $penalite = $adherent['Nombre_de_pénalité'] + 1;
        $update_adherent_stmt = $pdo->prepare("UPDATE adherent SET Nombre_de_pénalité = :penalite WHERE Id_adherent = :id_adherent");
        $update_adherent_stmt->bindParam(':penalite', $penalite);
        $update_adherent_stmt->bindParam(':id_adherent', $emprunt['Id_adherent']);
        $update_adherent_stmt->execute();
    }
    
    header('location: ../emprunt-admin.php');
} catch (PDOException $e) {
    echo 'Error updating timestamp: ' . $e->getMessage();
}


