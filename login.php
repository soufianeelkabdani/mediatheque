<?php
require_once('connect.php');
session_start();

echo "<script>console.log('Im here');</script>";
// Login
$data = json_decode(file_get_contents('php://input'), true);
$surname = $data['surName'];
$email = $data['loginEmail'];
$motdepasse = $data['loginPassword'];

// Prepare the SQL statement
$stmt = $pdo->prepare("SELECT * FROM adherent WHERE Surname = :surname AND Email = :email");

// Bind the input values to the prepared statement parameters
$stmt->bindParam(':surname', $surname);
$stmt->bindParam(':email', $email);

// Execute the query
$stmt->execute();

// Check if the query returned any rows
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // Verify the password using password_verify() function
    if (password_verify($motdepasse, $row['Mot_de_passe'])) {
        $_SESSION['surname'] = $row['Surname'];
        $_SESSION['id_adherent'] = $row['Id_adherent'];
        $_SESSION['admin'] = $row['admin'];


    } else {
        // The input password is incorrect, so the user is not authenticated
        echo "Login failed!";
        // Move the echo statement after the redirection code
    }
} else {
    // The input values don't exist in the "adhérent" table, so the user is not authenticated
    echo "Login failed!";
    // Move the echo statement after the redirection code
}
?>
