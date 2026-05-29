<?php
session_start();
include "konekcija.php";

if(!isset($_SESSION['uloga']) || $_SESSION['uloga'] != "admin"){
    die("Nemate pristup ovoj stranici.");
}

if(!isset($_GET['id'])){
    die("Nije poslat ID proizvoda.");
}

$id = (int)$_GET['id'];     // uzima podatke iz url (izmeni_proizvod.php?id=5)

// dohvacanje trenutnog proizvoda
$stmt = $konekcija->prepare("SELECT * FROM proizvodi WHERE id = ?");    // kreiramo sql upit sa odredjenim id, umjesto ? posle se ubacuje vr
$stmt->bind_param("i", $id);// ubacujemo vr id, povexujemo sa ? (? = $id)
$stmt->execute(); // izvrsava upit
$rez = $stmt->get_result(); // uzima rez

// provjera da li postoji prozivod
if($rez->num_rows == 0){
    die("Proizvod ne postoji.");
}

// fetch_assoc() uzima red iz baze kao asocijativni niz.
$row = $rez->fetch_assoc();
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
<h2>Izmeni proizvod</h2>

<form action="izmeni_proizvod.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
    Naziv: <input type="text" name="naziv" value="<?php echo $row['naziv']; ?>" required><br><br>
    Opis: <textarea name="opis" required><?php echo $row['opis']; ?></textarea><br><br>
    Cena: <input type="number" name="cena" step="0.01" value="<?php echo $row['cena']; ?>" required><br><br>
    Slika: <input type="file" name="slika"><br><br>
    Kategorija ID: <input type="number" name="kategorija_id" value="<?php echo $row['kategorija_id']; ?>" required><br><br>

    <button type="submit" name="update">Sačuvaj izmene</button>
</form>
<?php
// provjeri da li je forma poslata post metodom, da li postoji dugme ili input za izmjenu
if(isset($_POST['update'])){
    // uzmi podatke iz forme
    $naziv = $_POST['naziv'];
    $opis = $_POST['opis'];
    $cena = $_POST['cena'];
    $kategorija_id = $_POST['kategorija_id'];

    //  provera da li je dobra velicina slike
    if(!empty($_FILES['slika']['name'])){
        $allowed_types = ['image/jpeg','image/png'];
        $max_size = 2 * 1024 * 1024; // 2MB

    // Provjera tipa fajla
    if(!in_array($_FILES['slika']['type'], $allowed_types)){
        die("Nepodržani format slike. Dozvoljeni: jpg, png");
    }

    // Provjera veličine
    if($_FILES['slika']['size'] > $max_size){
        die("Slika je prevelika. Maksimalno 2MB");
    }

    // Ako je sve OK, premjesti fajl na server
    $slika = $_FILES['slika']['name'];
    if(!move_uploaded_file($_FILES['slika']['tmp_name'], "slike/".$slika)){ // smjesti u privremeni folder tmp_name, i onda prebaci u slike sa move_uploaded_file()
        die("Došlo je do greške pri uploadu slike.");
    }

    // UPDATE sa slikom u bazi
    $stmt = $konekcija->prepare("UPDATE proizvodi SET naziv=?, opis=?, cena=?, kategorija_id=?, slika=? WHERE id=?");
    $stmt->bind_param("ssdisi", $naziv, $opis, $cena, $kategorija_id, $slika, $id); // ssdisi - strinf, sting, double, integer, string, integer
} else {
    // UPDATE bez slike u bazi
    $stmt = $konekcija->prepare("UPDATE proizvodi SET naziv=?, opis=?, cena=?, kategorija_id=? WHERE id=?");
    $stmt->bind_param("ssdii", $naziv, $opis, $cena, $kategorija_id, $id);
}
    // izvrsavanje upita ako je uspjesno promijenjeno sve
    if($stmt->execute()){
        echo "Proizvod je uspešno izmenjen. <a href='admin.php'>Nazad na admin panel</a>";
    } else {
        echo "Greška: " . $stmt->error;
    }
}
?>
</body>
</html>