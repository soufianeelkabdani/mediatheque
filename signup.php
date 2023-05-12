<?php
require_once('connect.php');
// SIGN UP

$data = json_decode(file_get_contents('php://input'), true);

print_r($data);

$email = $data['email'];
$nom = $data['nom'];
$prenom = $data['prenom'];
$surname = $data['surname'];
$numtelephone = $data['numtelephone'];
$cin = $data['cin'];
$dateNaissance = $data['dateNaissance'];
$motdepasse = $data['motdepasse'];
$type = $data['type'];

// Check if email and surname already exist in the database
$sql = "SELECT COUNT(*) FROM adherent WHERE Email=:email OR Surname=:surname";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':surname', $surname);
$stmt->execute();

if ($stmt->fetch(PDO::FETCH_COLUMN) > 0) {
    header("location: login_rege.php?username_Pass=exits");
    exit;
}

// Encrypt the password
$hashed_password = password_hash($motdepasse, PASSWORD_DEFAULT);

// Prepare the SQL statement
$sql = "INSERT INTO adherent (Email, Nom, Prenom, Surname, Telephone, CIN, Date_de_naissance, Mot_de_passe, Type) VALUES (:email, :nom, :prenom, :surname, :numtelephone, :cin, :dateNaissance, :hashed_password, :type)";
$stmt = $pdo->prepare($sql);

// Bind parameters to statement
$stmt->bindParam(':email', $email);
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':surname', $surname);
$stmt->bindParam(':numtelephone', $numtelephone);
$stmt->bindParam(':cin', $cin);
$stmt->bindParam(':dateNaissance', $dateNaissance);
$stmt->bindParam(':hashed_password', $hashed_password);
$stmt->bindParam(':type', $type);

// Attempt to execute the statement
try {
    $stmt->execute();
    echo "Records added successfully.";
} catch (PDOException $e) {
    echo "ERROR: Could not execute $sql. " . $e->getMessage();
}
// Close the connection
unset($pdo);
