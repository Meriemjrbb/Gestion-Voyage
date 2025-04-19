<?php
include 'db_connect.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: admin.php?section=clients");
    exit;
}

$client_id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id = $client_id");
$conn->query("Delete from favoris where user_id=$client_id");

$redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
header("Location: $redirect_url");
exit();
?>