<?php
session_start();

$id = $_GET['id'];

// Inicijalizuj korpu ako ne postoji
if(!isset($_SESSION['korpa'])){
    $_SESSION['korpa'] = [];
}

// Dodaj proizvod ako već nije tu
if(!in_array($id, $_SESSION['korpa'])){
    $_SESSION['korpa'][] = $id;
}

// Vrati broj proizvoda u korpi kao JSON
header('Content-Type: application/json');
echo json_encode(['ukupno' => count($_SESSION['korpa'])]);
exit();
?>