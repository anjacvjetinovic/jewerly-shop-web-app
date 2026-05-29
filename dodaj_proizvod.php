<?php

// admin dodaje proizvode preko admin panela
session_start();
include "konekcija.php";

if($_SESSION['uloga'] != "admin"){
    die("Nemate pristup.");
}

$naziv = $_POST['naziv'];
$opis = $_POST['opis'];
$cena = $_POST['cena'];
$kategorija_id = $_POST['kategorija_id'];

$slika = $_FILES['slika']['name'];
$tmp = $_FILES['slika']['tmp_name'];
$velicina = $_FILES['slika']['size'];
$tip = strtolower(pathinfo($slika, PATHINFO_EXTENSION));

$dozvoljeni = ["jpg","jpeg","png"];

if(!in_array($tip, $dozvoljeni)){
    die("Dozvoljeni su samo JPG i PNG fajlovi.");
}

if($velicina > 2000000){
    die("Fajl je prevelik. Max 2MB.");
}

move_uploaded_file($tmp, "slike/".$slika);

$sql = "INSERT INTO proizvodi (naziv, opis, cena, slika, kategorija_id)
        VALUES ('$naziv','$opis','$cena','$slika','$kategorija_id')";

if($konekcija->query($sql)){
    header("Location: admin.php");
    exit();
}else{
    echo "Greška pri unosu.";
}
?>