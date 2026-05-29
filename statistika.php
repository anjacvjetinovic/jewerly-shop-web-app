<!--
Čita ceo log.txt fajl.
Broji pristupe po tipu korisnika (admin i user) tako što traži email i proverava u bazi tip korisnika.
Prikazuje tabelu sa brojem pristupa i ukupnim brojem prijava.
Dugme “Nazad” vraća na Admin Panel.
-->

<?php
session_start();
if(!isset($_SESSION['uloga']) || $_SESSION['uloga'] != "admin"){
    die("Nemate pristup ovoj stranici.");
}

$log_file = "log.txt";

$pristupi = [
    'admin' => 0,
    'user' => 0,
    'ukupno' => 0,
];

if(file_exists($log_file)){
    $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach($lines as $line){
        $pristupi['ukupno']++;

        // Ekstrakt email iz linije
        preg_match('/^(.+?) se prijavio/', $line, $matches);
        $email = $matches[1] ?? '';

        // Spoji sa bazom da odredi tip korisnika
        if(!empty($email)){
            include "konekcija.php";
            $res = $konekcija->query("SELECT uloga FROM korisnici WHERE email='$email' LIMIT 1");
            if($res->num_rows > 0){
                $row = $res->fetch_assoc();
                $uloga = $row['uloga'];
                if(isset($pristupi[$uloga])){
                    $pristupi[$uloga]++;
                }
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Statistika pristupa</title>
<link href="./css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-4">
<h2>Statistika pristupa sistema</h2>
<a href="admin.php" class="btn btn-secondary mb-3">Nazad na Admin Panel</a>
<hr>

<table class="table table-bordered">
<tr>
    <th>Tip korisnika</th>
    <th>Broj pristupa</th>
</tr>
<tr>
    <td>Admini</td>
    <td><?php echo $pristupi['admin']; ?></td>
</tr>
<tr>
    <td>Korisnici</td>
    <td><?php echo $pristupi['user']; ?></td>
</tr>
<tr>
    <td>Ukupno</td>
    <td><?php echo $pristupi['ukupno']; ?></td>
</tr>
</table>

</div>

<h3 style="margin-top: 30px;">Procenat pristupa po tipu korisnika</h3>
<div class="d-flex justify-content-center mt-4 mb-4">
    <canvas id="pristupiPie" width="300" height="300"></canvas>
</div>

<script>
const ctxPie = document.getElementById('pristupiPie').getContext('2d');
const pristupiPie = new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: ['Admini', 'Korisnici'],
        datasets: [{
            label: 'Pristupi',
            data: [<?php echo $pristupi['admin']; ?>, <?php echo $pristupi['user']; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',  // admin
                'rgba(54, 162, 235, 0.7)'   // korisnici
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: false, // grafikon manji i ne raste preko ekrana
        plugins: {
            legend: {
                position: 'bottom',
            },
        }
    }
});
</script>

</body>
</html>