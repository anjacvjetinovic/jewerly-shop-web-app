<?php
session_start();
include "konekcija.php";

if($_SESSION['uloga'] != "admin"){
    die("Nemate pristup.");
}

$id = intval($_GET['id']); // sigurnost

$sql = "UPDATE proizvodi SET aktivan = 0 WHERE id = $id";
$konekcija->query($sql);

header("Location: admin.php");
exit();
?>