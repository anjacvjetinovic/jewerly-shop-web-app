<?php
session_start();
include "konekcija.php";

if(!isset($_SESSION['uloga']) || $_SESSION['uloga'] != "admin"){
    die("Nemate pristup ovoj stranici.");
}

$porudzbina_id = intval($_GET['id']);

// Dohvati podatke o porudžbini i korisniku
$sql_info = "SELECT p.datum, p.ukupna_cena, k.email
             FROM porudzbine p
             JOIN korisnici k ON p.korisnik_id = k.id
             WHERE p.id = $porudzbina_id";

$rez_info = $konekcija->query($sql_info);

if($rez_info && $rez_info->num_rows > 0){
    $info = $rez_info->fetch_assoc();

    $email = $info['email'];
    $datum_porudzbine = $info['datum'];
    $ukupna_cena = number_format($info['ukupna_cena'], 2, '.', '');
    $datum_isporuke = date("Y-m-d", strtotime($datum_porudzbine . " +3 days"));
} else {
    die("Porudžbina ne postoji.");
}

// Promeni status porudžbine u 'poslato'
$konekcija->query("UPDATE porudzbine SET status='poslato' WHERE id=$porudzbina_id");

// Postavi proizvode iz porudžbine na aktivan = 0
$sql = "SELECT proizvod_id FROM stavke_porudzbine WHERE porudzbina_id=$porudzbina_id";
$result = $konekcija->query($sql);

while($row = $result->fetch_assoc()){
    $konekcija->query("UPDATE proizvodi SET aktivan=0 WHERE id=".$row['proizvod_id']);
}

// Dodaj u txt fajl potvrdu
file_put_contents(
    "porudzbine.txt",
    "Porudzbina #$porudzbina_id | Email: $email | Datum: $datum_porudzbine | Isporuka: $datum_isporuke | Ukupno: $ukupna_cena RSD\n",
    FILE_APPEND
);

header("Location: pregled_porudzbina.php");
exit();
?>