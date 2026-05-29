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
<title>Pregled porudžbina</title>
<link href="./css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
<h2>Porudžbine na čekanju</h2>
<a href="admin.php" class="btn btn-secondary mb-3">Nazad na Admin Panel</a>

<hr>

<?php
$sql = "SELECT p.id as porudzbina_id, p.datum, p.status, k.email 
        FROM porudzbine p
        JOIN korisnici k ON p.korisnik_id = k.id
        WHERE p.status='na cekanju'";
$result = $konekcija->query($sql);

if($result->num_rows == 0){
    echo "<p>Nema porudžbina na čekanju.</p>";
} else {
    echo "<table class='table table-bordered'>
            <tr>
                <th>ID</th>
                <th>Email korisnika</th>
                <th>Datum</th>
                <th>Stavke</th>
                <th>Akcija</th>
            </tr>";
    while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>".$row['porudzbina_id']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['datum']."</td>";

        // Dohvati proizvode iz stavke_porudzbine
        $sql2 = "SELECT s.proizvod_id, pr.naziv 
                 FROM stavke_porudzbine s
                 JOIN proizvodi pr ON s.proizvod_id = pr.id
                 WHERE s.porudzbina_id=".$row['porudzbina_id'];
        $res2 = $konekcija->query($sql2);
        echo "<td>";
        while($r2 = $res2->fetch_assoc()){
            echo $r2['naziv']."<br>";
        }
        echo "</td>";

        // Dugme za potvrdu
        echo "<td><a href='potvrdi_porudzbinu.php?id=".$row['porudzbina_id']."' class='btn btn-success'>Potvrdi slanje</a></td>";

        echo "</tr>";
    }
    echo "</table>";
}
?>
</div>

<!--
file() čita fajl u niz, gde je svaki red jedan element niza.
FILE_IGNORE_NEW_LINES uklanja \n sa kraja linija.
Prikazuje se kao <ul> lista, pa admin lako vidi sve porudžbine koje su već poslali i koje su u txt fajlu
-->
<h2>Porudžbine iz TXT fajla</h2>
<?php
$txt_file = 'porudzbine.txt';

if(file_exists($txt_file)){
    $lines = file($txt_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if(count($lines) == 0){
        echo "<p>Nema porudžbina u TXT fajlu.</p>";
    } else {
        echo "<ul class='list-group'>";
        foreach($lines as $line){
            echo "<li class='list-group-item'>".$line."</li>";
        }
        echo "</ul>";
    }
} else {
    echo "<p>TXT fajl ne postoji.</p>";
}
?>
</body>
</html>