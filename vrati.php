<?php
session_start();
include "konekcija.php";

if(!isset($_SESSION['uloga']) || $_SESSION['uloga'] != "admin"){
    die("Nemate pristup.");
}

$id = intval($_GET['id']);

$sql = "UPDATE proizvodi SET aktivan = 1 WHERE id = $id";
$konekcija->query($sql);

header("Location: admin.php");
exit();
?>