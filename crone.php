<?php
require_once('connect.php');

try {
 $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $deleteSql = "DELETE FROM reservation WHERE date_d_expiration < DATE_SUB(NOW(), INTERVAL 24 HOUR) AND Id_reservation NOT IN (SELECT Id_reservation FROM emprunt)";
  $deleteStmt = $dbh->prepare($deleteSql);
  $deleteStmt->execute();
} catch (PDOException $e) {
  echo "Erreur: " . $e->getMessage();
}
