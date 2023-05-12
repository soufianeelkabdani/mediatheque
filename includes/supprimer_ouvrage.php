<?php
require_once('../connect.php');
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the ID of the item to delete
  $id = $_POST['id'];

  // Prepare and execute the SQL statement
  $query = "DELETE FROM ouvrage WHERE Id_ouvrage = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$id]);

  // Redirect the user to the home page
  header('Location: admin.php');
  exit();
} else {
  // The form was not submitted, so redirect the user to the home page
  header('Location: admin.php');
  exit();
}
?>