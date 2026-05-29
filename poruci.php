<?php
session_start();
include "konekcija.php";

if(!isset($_SESSION['korisnik_id']) || empty($_SESSION['korpa'])){
    header("Location: korpa.php");
    exit();
}

$korisnik_id = $_SESSION['korisnik_id'];
$ids = $_SESSION['korpa'];

// Izračunaj datum isporuke (3 dana od danas)
$datum_isporuke = date("Y-m-d", strtotime("+3 days"));
$datum_porudzbine = date("Y-m-d H:i:s");

// izračunaj ukupnu cenu proizvoda
    $ukupna_cena = 0;
    $ids_str = implode(",", $ids);
    $sql_cena = "SELECT SUM(cena) as ukupna_cena FROM proizvodi WHERE id IN ($ids_str)";
    $res_cena = $konekcija->query($sql_cena);
    if($res_cena){
        $row_cena = $res_cena->fetch_assoc();
        $ukupna_cena = $row_cena['ukupna_cena'];
    }

    // Ubaci novu porudžbinu sa statusom 'na cekanju'
    $sql = "INSERT INTO porudzbine (korisnik_id, datum, ukupna_cena, status) VALUES ('$korisnik_id', '$datum_porudzbine', '$ukupna_cena', 'na cekanju')";
    if($konekcija->query($sql)){
        $porudzbina_id = $konekcija->insert_id;

    // Ubaci stavke u stavke_porudzbine
        foreach($ids as $id){
            $konekcija->query("INSERT INTO stavke_porudzbine (porudzbina_id, proizvod_id, kolicina) VALUES ('$porudzbina_id', '$id', 1)");
    }

    // Dohvati email korisnika
    $result = $konekcija->query("SELECT email FROM korisnici WHERE id='$korisnik_id'");
    $korisnik = $result->fetch_assoc();
    $email = $korisnik['email'];

    // Zatim upiši u txt fajl u željenom formatu
    file_put_contents(
        "porudzbine.txt", 
        "Porudzbina #$porudzbina_id | Email: $email | Datum: $datum_porudzbine | Isporuka: $datum_isporuke | Ukupno: ".$ukupna_cena." RSD\n", 
        FILE_APPEND
    );
    
    // Očisti korpu
    unset($_SESSION['korpa']);

    $_SESSION['success'] = "Uspešno ste izvršili porudžbinu. Možete je očekivati $datum_isporuke.";
    header("Location: korpa.php");
    exit();
} else {
    $_SESSION['error'] = "Greška prilikom poručivanja.";
    header("Location: korpa.php");
    exit();
}