<?php
session_start();
include "konekcija.php";
?>

<!doctype html>
<html lang="en">
 <head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="description" content="Zlatara Koral je prodavnica zenskog nakita, satova, novcanika. Nudimo Vam raznovrsnu ponudu, 
  za svakoga po nesto! U nasoj zlatari mozete pronaci bogat izbor nakita od zlata, srebra i dragog kamenja - od elegantnih ogrlica i narukvica, do 
  prstenova i mindjusa koje ce upotpuniti svaku priliku. Pazljivo biramo svaki komad! Mogucnost dostave na adresu. ">
 <meta name="keywords" content="Fruitables, Voce, Povrce, Organski
proizvodi">
 <meta name="author" content="Ime i prezime, e-mail">
 <title>Zlatara "Koral"</title>
 <link rel="stylesheet" href="./style.css">
 <link href="./css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="./fontawesome/fontawesome-free-6.7.2-web/css/all.min.css">
 </head>

 <body>
  <!-- nav -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="indeks.php"> <img src="./slike/logo.jpeg" alt="logo" width="110" ></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="indeks.php">Početna</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="onama.html" >O nama</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="aktuelno.html">Aktuelno</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Ponuda</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="prstenje.php">Prstenje</a></li>
              <li><a class="dropdown-item" href="ogrlice.php" >Ogrlice</a></li>
              <li><a class="dropdown-item" href="satovi.php" >Satovi</a></li>
              <li><a class="dropdown-item" href="narukvice.php">Narukvice</a></li>
  
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="deca.html">Aksesoari za decu</a></li>
  
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="muskarci.html">Muški satovi</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="galerija.html">Galerija</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="kontakt.html" >Kontakt</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="mapa.html">Mapa</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="faq.html">FAQ</a>
          </li>
        </ul>
        
        <ul class="navbar-nav me-5">
          <?php if(isset($_SESSION['uloga']) && $_SESSION['uloga'] == "admin"): ?>
            <!-- admin prijavljen → admin panel -->
          <li class="nav-item">
          <a class="nav-link text-danger" href="admin.php">Admin Panel</a>
          </li>
          <?php endif; ?>

         <li class="nav-item">
          <?php if(isset($_SESSION['korisnik_id'])): ?>
            <!-- Korisnik prijavljen → korpa -->
          <a class="nav-link" href="korpa.php"><i class="fa-solid fa-cart-shopping fa-2x"></i></a>
            <?php else: ?>
            <!-- Gost → omiljeni -->
            <a class="nav-link" href="omiljeni.php">
                <i class="fa-regular fa-heart fa-2x"></i>
            </a>
        <?php endif; ?>

          </li>
          <li class="nav-item">
          <!--<a class="nav-link" href="nalog.php"><i class="fa-solid fa-user fa-2x"></i></a></li>-->
            <?php if(isset($_SESSION['korisnik_id'])): ?>
              <a class="nav-link" href="logout.php">
                  <i class="fa-solid fa-right-from-bracket fa-2x"></i>
              </a>
              <?php else: ?>
                <a class="nav-link" href="nalog.php">
                    <i class="fa-solid fa-user fa-2x"></i>
                </a>
            <?php endif; ?>
          </ul>
  
      </div>
    </div>
  </nav>
  <!-- nav end -->
  <br>
   <section>
    <div class="container">
      <h2 class="display-4" style="text-align: center;">Korpa</h2>

      <!--dodavanje poruke o uspjesnoj kupovini-->
      <?php
      if(isset($_SESSION['success'])){
          echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
          unset($_SESSION['success']);
      }
      ?>
    <hr>
    <div class="row">
    
<!--dodavanje proizvoda u korpu -->
<?php
// provea da li korpa postoj u sesiji i da li je prazna
if(!isset($_SESSION['korpa']) || empty($_SESSION['korpa'])){
    echo "Nemate proizvoda u korpi.";
    exit();
}

$ids = implode(",", $_SESSION['korpa']);  // pretvara niz id poizvoda u sql i pravi string
$sql = "SELECT * FROM proizvodi WHERE id IN ($ids) AND aktivan = 1";  // uzmi sve proizvode sa tim id u bazi
$result = $konekcija->query($sql);  // izvrsi upit

// prolazimo kroz sve proizvode i dodajemo ih na stranicu kao kartice
while($row = $result->fetch_assoc()){
?>
    <div class="card mb-3" style="width: 18rem;">
        <img src="slike/<?php echo $row['slika']; ?>" class="card-img-top">
        <div class="card-body">
            <h5><?php echo $row['naziv']; ?></h5>
            <p><?php echo $row['cena']; ?> RSD</p>
        </div>
    </div>
<?php
}
?>

    </div>
    </div>
    </section>
    <br><br>

<!-- da prikaze ukupnu cenu na dnu i dugme za porucivanje -->
<div class="d-flex justify-content-center mt-4 mb-4">
<?php
$ukupno = 0;

foreach($_SESSION['korpa'] as $id){
    $sql = "SELECT cena FROM proizvodi WHERE id=$id";
    $r = $konekcija->query($sql);
    $p = $r->fetch_assoc();

    $ukupno += $p['cena'];
}

echo "<h4>Ukupno: $ukupno RSD</h4>";
?>
<br>
<form action="poruci.php" method="POST">
    <button class="btn btn-success">Poruči</button>
</form>
<br><br>
</div>

 <!-- footer -->
 <footer class="text-center text-lg-start bg-body-tertiary text-muted">
      
  <section class="" style="background-color: rgb(238,221,203)  ;">
 
    <div class="me-5 d-none d-lg-block" style="background-color: rgb(238,221,203)  ;">
      <span id="info"  class="user-select-none"><i class="textfooter"><i class="fa-solid fa-circle-info"></i>Korisne informacije: </i><hr class="linija"></span>
      
    </div>
       <div class="row mt-3" style="background-color: rgb(238,221,203)  ;">
       
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4" style="background-color: rgb(238,221,203);">
       
          <h6 class="text-uppercase fw-bold mb-4 user-select-none">
            <i class="fa-regular fa-heart"></i>&nbsp;KORAL
          </h6>
          <p class="user-select-none">
         <i class="textfooter"> Zlatara Koral - Mesto gde ćete pronaći nakit koji spaja bezvremensku eleganciju i vrhunski 
          kvalitet za svaku priliku. Svaki komad je pažljivo izabran kako bi ulepšao Vaše posebne trenutke i trajao celi život.
          Nakit koji govori više od reči!</p>
         </i>
        </div>
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
         <a href="index.php"> <img src="slike/logo.jpeg" class="rounded mx-auto d-block" alt="logo" style="max-width: 150px;"> </a>
        </div>
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4" style="background-color: rgb(238,221,203)  ;">
          <h6 class="text-uppercase fw-bold mb-4 user-select-none"><i class="fa-solid fa-square-phone"></i> Kontakt</h6>
          <p class="user-select-none textfooter"><i class="fas fa-home me-3"></i>Vojvode Stepe 283</p>
          <p class="user-select-none textfooter">
            <i class="fas fa-envelope me-3 user-select-none"></i>
            info@zlatara_koral.com
          </p>
          <p class="user-select-none textfooter"><i class="fas fa-phone me-3 user-select-none"></i>+381 64/234-123</p>
          <p class="user-select-none textfooter"><i class="fas fa-phone me-3 user-select-none"></i>011/1234-123</p>
        </div>
      </div>
    </div>

    <div class="footer-social">
      <div class="social-links">
      <a href="https://www.instagram.com/viserbgd" target="_blank" class="ig"><i class="fa-brands fa-instagram fa-2x"></i></a>
      <a href="https://www.facebook.com/viserbgd/?locale=sr_RS" target="_blank" class="f"><i class="fa-brands fa-facebook fa-2x"></i></a>
      <a href="https://www.youtube.com/@avt_viser_atuss" target="_blank" class="y"><i class="fa-brands fa-youtube fa-2x"></i></a>
      <a href="https://www.linkedin.com/school/viser-belgrade/" target="_blank" class="i"><i class="fa-brands fa-linkedin fa-2x"></i></a>
      </div>
      </div>
    <div class="payment-options">
      <img src="./slike/payment.png" alt="Payment Options">
    </div>
  </section>    
 
  <div class="text-center p-4 user-select-none" style="background-color: rgb(183,110,121)">
    <a href="index.php"  class="kopi">KORAL</a> 

    <!-- copyright -->
    <i class="fa-solid fa-copyright " ></i>  Sva prava zadržava. <br> 
    Designed By <a href="https://www.instagram.com/anjaa.c_/" class="kopi" target="_blank">Anja Cvjetinovic NRT-147/23.</a>
  </div>
</footer>
<!--footer end-->

 <script src="./js/bootstrap.bundle.min.js" ></script>
 <script src="./fontawesome/js/all.min.js"></script>

<script>
setTimeout(function(){
    let alert = document.querySelector(".alert");
    if(alert){
        alert.style.display = "none";
    }
},3000);
</script>

 </body>
</html>