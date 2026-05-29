<?php
session_start();
include "konekcija.php";

$_SESSION['form_data'] = $_POST;

$ime = $_POST['ime'];
$prezime = $_POST['prezime'];
$email = $_POST['email'];
$lozinka1 = $_POST['lozinka'];
$lozinka2 = $_POST['lozinka2'];

/* PROVERA IMENA */
if(strlen($ime) < 2){
    $_SESSION['error'] = "Ime mora imati bar 2 karaktera.";
    header("Location: nalog.php");
    exit();
}

/* DUZINA LOZINKE */
if(strlen($lozinka1) < 6){
    $_SESSION['error'] = "Lozinka mora imati bar 6 karaktera.";
    header("Location: nalog.php");
    exit();
}

/* PROVERA LOZINKE */
if ($lozinka1 !== $lozinka2) {
    $_SESSION['error'] = "Lozinke se ne poklapaju.";
    header("Location: nalog.php");
    exit();
}

/* PROVERA DA LI EMAIL VEĆ POSTOJI */
$sql_provera = "SELECT id FROM korisnici WHERE email='$email'";
$result = $konekcija->query($sql_provera);

if($result->num_rows > 0){
    $_SESSION['error'] = "Korisnik sa tim emailom već postoji.";
    header("Location: nalog.php");
    exit();
}

/* HASH LOZINKE */
$lozinka_hash = password_hash($lozinka1, PASSWORD_DEFAULT);

/* UBACIVANJE U BAZU */
$sql = "INSERT INTO korisnici (ime, prezime, email, lozinka) 
        VALUES ('$ime','$prezime','$email','$lozinka_hash')";

if($konekcija->query($sql)){
    $korisnik_id = $konekcija->insert_id;

    $_SESSION['korisnik_id'] = $korisnik_id;
    $_SESSION['uloga'] = "user";

    // kolacic
    setcookie("korisnik_email", $email, time()+3600);

    file_put_contents("registracije.txt", $email . " se registrovao\n", FILE_APPEND);

    $_SESSION['success'] = "Uspešno ste kreirali nalog!";
    unset($_SESSION['form_data']);
    
    header("Location: nalog.php");
    exit();

}else{
    $_SESSION['error'] = "Greška prilikom registracije.";
    header("Location: nalog.php");
    exit();
}
?>