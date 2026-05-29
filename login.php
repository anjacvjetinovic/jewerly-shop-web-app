<?php
session_start();
include "konekcija.php";

// uzimamo podatke iz login forme
$email = $_POST['email'];
$lozinka = $_POST['lozinka'];

// upit za trazenje korisnika po emailu
$sql = "SELECT * FROM korisnici WHERE email='$email'";
$result = $konekcija->query($sql);

// ako imamo redova > 0 u bazi
if($result->num_rows > 0){
    $korisnik = $result->fetch_assoc(); // uzmi red iz baze

    // provjera lozinke (u bazi sacuvana kao hash ne kao tekst, pa se provjerava sa tim)
    if(password_verify($lozinka, $korisnik['lozinka'])){
        $_SESSION['korisnik_id'] = $korisnik['id']; // cuvaj id korisnika
        $_SESSION['uloga'] = $korisnik['uloga'];    // i ulogu

        // kolacic - browser pamti email korisnika 1 sat.
        setcookie("korisnik_email", $email, time()+3600);

        // upis logina u fajl
        $vrijeme = date("d.m.Y H:i:s");
        file_put_contents("log.txt", $email . " se prijavio " .$vrijeme . "\n", FILE_APPEND);

        header("Location: indeks.php");
        exit();

    } else {
        $_SESSION['error'] = "Pogrešna lozinka!";
        header("Location: nalog.php?form=login");
        exit();
    }

} else {
    $_SESSION['error'] = "Korisnik sa tim emailom ne postoji!";
    header("Location: nalog.php?form=login");
    exit();
}
?>