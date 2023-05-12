<?php
require_once('connect.php');

// Get the user-entered values
$email = $_POST['email'];
$surname = $_POST['surname'];
$password = $_POST['password'];

// Prepare and execute the SELECT query
$stmt = $pdo->prepare('SELECT * FROM adherent WHERE Email = :email AND Surname = :surname');
$stmt->bindParam(':email', $email);
$stmt->bindParam(':surname', $surname);
$stmt->execute();


$data = [
    'admin' => false,
    'password' => false,
    'penalities' => 0,
];
// if the user exists 
if ($stmt->rowCount() > 0) {
    // Fetch the result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // if the password is correct
    if (password_verify($password, $row['Mot_de_passe'])) {
        $data['admin'] = (bool)$row['admin'];
        $data['password'] = true;
        $data['penalities'] = $row['Nombre_de_pénalité'];
    }
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
