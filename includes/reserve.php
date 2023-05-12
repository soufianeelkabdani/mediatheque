<?php
require_once('../connect.php');
session_start();

// Check if Id_ouvrage is set
if (!isset($_GET['id'])) {
    echo "Error: Id_ouvrage is not set";
    exit;
}

// Check if Id_adherent is set
if (!isset($_SESSION['id_adherent'])) {
    echo "Error: Id_adherent is not set";
    exit;
}

// Prepare the SQL statement to count existing reservations
$sqlCount = "SELECT COUNT(*) AS reservation_count FROM Reservation WHERE Id_adherent = :Id_adherent";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->bindParam(':Id_adherent', $_SESSION['id_adherent']);
$stmtCount->execute();
$reservationCount = $stmtCount->fetch(PDO::FETCH_ASSOC)['reservation_count'];

// Check if the user has already made three reservations
if ($reservationCount >= 3) {
    echo "<script>if(confirm('you cant make more than 3')) window.location.href= '../ouvres.php';</script>";
    exit;
}

// Prepare the SQL statement to make a reservation
$sql = "INSERT INTO Reservation (date_d_expiration, Id_ouvrage, Id_adherent)
        VALUES (:date_d_expiration, :Id_ouvrage, :Id_adherent)";
$stmt = $pdo->prepare($sql);

// Set parameter values
$date_d_expiration = new DateTime();
$date_d_expiration->modify('+24 hours');
$date_d_expiration = $date_d_expiration->format('Y-m-d H:i:s');

$Id_adherent = $_SESSION['id_adherent'];
$Id_ouvrage = $_GET['id'];

// Validate and sanitize input
// ...

// Update the status of the ouvrage to "Reserved"
$sqlUpdateStatus = 'UPDATE ouvrage SET Status = :Status WHERE Id_ouvrage = :Id_ouvrage';
$stmtUpdateStatus = $pdo->prepare($sqlUpdateStatus);
$Status = 'Reservé';
$stmtUpdateStatus->bindParam(':Status', $Status);
$stmtUpdateStatus->bindParam(':Id_ouvrage', $Id_ouvrage);
$stmtUpdateStatus->execute();

// Bind parameters to the reservation statement
$stmt->bindParam(':date_d_expiration', $date_d_expiration);
$stmt->bindParam(':Id_ouvrage', $Id_ouvrage);
$stmt->bindParam(':Id_adherent', $Id_adherent);

// Execute the reservation statement and handle errors
try {
    if ($stmt->execute()) {
        header('location: ../ouvres.php');
    } else {
        echo "Error executing statement";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>
