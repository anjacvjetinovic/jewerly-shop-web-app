<!-- dodavanje bez ajaxa !!!!! -->
<?php
session_start();

$id = $_GET['id'];

// Inicijalizuj omiljeni ako ne postoji
if(!isset($_SESSION['korpa'])){
    $_SESSION['korpa'] = [];
}

// Dodaj proizvod ako već nije tu
if(!in_array($id, $_SESSION['korpa'])){
    $_SESSION['korpa'][] = $id;
}

// POSTAVLJAMO FLASH PORUKU
$_SESSION['flash_poruka'] = "Proizvod je dodat u korpu";

// Vrati nazad na stranicu
$vrati = $_SERVER['HTTP_REFERER'];
header("Location: " . $vrati);
exit();
?>