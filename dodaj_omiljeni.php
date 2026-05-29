<?php
session_start();

$id = $_GET['id'];

// Inicijalizuj omiljeni ako ne postoji
if(!isset($_SESSION['omiljeni'])){
    $_SESSION['omiljeni'] = [];
}

// Dodaj proizvod ako već nije tu
if(!in_array($id, $_SESSION['omiljeni'])){
    $_SESSION['omiljeni'][] = $id;
}

// POSTAVLJAMO FLASH PORUKU
$_SESSION['flash_poruka'] = "Proizvod je dodat u omiljene ❤️";

// Vrati nazad na stranicu
$vrati = $_SERVER['HTTP_REFERER'];
header("Location: " . $vrati);
exit();
?>