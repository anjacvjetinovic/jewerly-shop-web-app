<?php

session_start();
include "konekcija.php";

if(!isset($_SESSION['uloga']) || $_SESSION['uloga'] != "admin"){
    die("Nemate pristup ovoj stranici.");
}
?>

<!doctype html>
<html lang="en">
 <head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="description" content="Zlatara Koral je prodavnica zenskog nakita, satova, novcanika. Nudimo Vam raznovrsnu ponudu, 
  za svakoga po nesto! U nasoj zlatari mozete pronaci bogat izbor nakita od zlata, srebra i dragog kamenja - od elegantnih ogrlica i narukvica, do 
  prstenova i mindjusa koje ce upotpuniti svaku priliku. Pazljivo biramo svaki komad! Mogucnost dostave na adresu. ">
 <meta name="author" content="Ime i prezime, e-mail">
 <title>Zlatara "Koral"</title>

  <link rel="stylesheet" href="./style.css">   <!--moj stil-->
 <link href="./css/bootstrap.min.css" rel="stylesheet"> <!--bootstrap--> 
 <link rel="stylesheet" href="./fontawesome/fontawesome-free-6.7.2-web/css/all.min.css">
 </head>

  <body style="background-color: rgb(238,221,203); color: rgb(183,110,121);">
<h2>Dodaj novi proizvod</h2>

<form action="dodaj_proizvod.php" method="POST" enctype="multipart/form-data">
    Naziv: <input type="text" name="naziv" required><br><br>
    Opis: <textarea name="opis" required></textarea><br><br>
    Cena: <input type="number" name="cena" step="0.01" required><br><br>
    Slika: <input type="file" name="slika" required><br><br>
    <select name="kategorija_id" required>
        <option value="">-- Izaberite kategoriju --</option>
        <option value="1">1 - Prsten</option>
        <option value="2">2 - Ogrlica</option>
        <option value="3">3 - Sat</option>
    </select>
    <br><br>

    <button type="submit">Dodaj proizvod</button>
</form>

<hr>

<h2>Lista proizvoda</h2>

<?php
$rez = $konekcija->query("SELECT * FROM proizvodi");

// fetch_assoc() uzima jedan red iz baze kao asocijativni niz.
// $row sadrži kolone iz tabele
while($row = $rez->fetch_assoc()){
    echo "<div>";
    echo $row['naziv'] . " - " . $row['cena'] . " din ";
     echo "<a href='izmeni_proizvod.php?id=".$row['id']."'>Izmeni</a> | ";
?>
    <td>
    <?php 
    if($row['aktivan'] == 1){ ?>
        <a href="obrisi_proizvod.php?id=<?php echo $row['id']; ?>">Obriši</a>
    <?php } else { ?>
        <a href="vrati.php?id=<?php echo $row['id']; ?>">Vrati</a>
    <?php } ?>
    </td>
    <?php 
    echo "</div><hr>";
}
?>

<a href="indeks.php" class="btn btn-secondary mb-3">Nazad na početnu</a><br>
<a href="pregled_porudzbina.php" class="btn btn-secondary mb-3">Pregled porudžbina</a><br>
<a href="statistika.php" class="btn btn-secondary mb-3">Statistika pristupa</a><br>

</body>
</html>