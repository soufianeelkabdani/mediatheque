<?php

require_once('../connect.php'); // assuming you have a separate file for database connection
session_start();
// Prepare the SQL statement
$sql = "INSERT INTO Emprunt (Id_ouvrage, Id_adherent, Id_reservation) VALUES ( :Id_ouvrage, :Id_adherent, :Id_reservation)";
$stmt = $pdo->prepare($sql);

// Bind parameters to the statement
$Id_reservation = $_GET['id'];

// Prepare the SQL query to select the reservation
$sql = "SELECT * FROM reservation WHERE Id_reservation = :id";
// Prepare the statement
$stmt2 = $pdo->prepare($sql);
// Bind the reservation_id parameter to the statement
$stmt2->bindParam(':id', $Id_reservation);
// Execute the statement
$stmt2->execute();

$row = $stmt2->fetch(PDO::FETCH_ASSOC);
// Close the database connection




$Id_ouvrage  = $row['Id_ouvrage'];
$Id_adherent = $row['Id_adherent'];

$sql = 'UPDATE ouvrage SET Status = :Status WHERE Id_ouvrage = :Id_ouvrage';
$stmt3 = $pdo->prepare($sql);
$Status = 'Emprunté';
$stmt3->bindParam(':Status', $Status);
$stmt3->bindParam(':Id_ouvrage', $Id_ouvrage);
$stmt3->execute();

$stmt->bindParam(':Id_ouvrage', $Id_ouvrage);
$stmt->bindParam(':Id_adherent', $Id_adherent);
$stmt->bindParam(':Id_reservation', $Id_reservation);

// Execute the statement
try {
    $stmt->execute();
    header('location: ../reservation-admin.php');
} catch (PDOException $e) {
    echo "error: " . $e->getMessage();
}

// Close the connection
$pdo = null;
