<?php
$host = 'localhost';
$user = 'root';
$password = '1234';
$dbname = 'gestion_voyages';

// Connexion à la base de données
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}
?>