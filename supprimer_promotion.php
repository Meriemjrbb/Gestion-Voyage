<?php
include 'db_connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM promotions WHERE id = $id";

if ($conn->query($sql)) {
    $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header("Location: $redirect_url");
    exit();
} else {
    echo "Erreur : " . $conn->error;
}
?>