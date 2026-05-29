<?php 
session_start(); 
//ako u sesiji postoji form_data, uzmi te podatke
//sluzi da bi forma ostala popunjena ako dođe do greške pri registraciji
$form_data = $_SESSION['form_data'] ?? [
    'ime' => '',
    'prezime' => '',
    'email' => ''
];

?>

<!doctype html>
<html lang="en">
 <head>
 <meta charset="utf-8">
 <meta name="author" content="Ime i prezime, e-mail">
 <title>Zlatara "Koral"</title>
 <link href="./css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./style.css">

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

  <!-- provera da li se poklapaju lozinke ili ne - kreiranje naloga -->
  <?php
  if(isset($_SESSION['error'])){
      echo '<div id="poruka" class="alert alert-danger">'.$_SESSION['error'].'</div>';
      unset($_SESSION['error']);
  }

  if(isset($_SESSION['success'])){
      echo '<div id="poruka" class="alert alert-success">'.$_SESSION['success'].'</div>';
      unset($_SESSION['success']);
  }
  ?>

  <div class="container mt-4 d-flex justify-content-center">
    <!-- Registracija -->
    <div id="register-form" style="display:<?php echo (isset($_GET['form']) && $_GET['form']=="login") ? 'none' : 'block'; ?>;">
        <h2 class="display-4">Kreiranje naloga</h2><hr>
        
        <form method="POST" action="registracija.php">
            <div class="mb-3">
                <label for="ime" class="form-label"><i class="fa-solid fa-user"></i> Ime</label>
                <input type="text" name="ime" class="form-control" id="ime" value="<?php echo htmlspecialchars($form_data['ime']); ?>" placeholder="Unesite ime" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="prezime" class="form-label"><i class="fa-solid fa-user"></i> Prezime</label>
                <input type="text" name="prezime" class="form-control" id="prezime" value="<?php echo htmlspecialchars($form_data['prezime']); ?>" placeholder="Unesite prezime" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><i class="fa-solid fa-envelope"></i> Email</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo htmlspecialchars($form_data['email']); ?>" placeholder="Unesite email" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="lozinka" class="form-label"><i class="fa-solid fa-lock"></i> Lozinka</label>
                <input type="password" name="lozinka" class="form-control" id="lozinka" placeholder="Unesite lozinku" required autocomplete="new-password">
            </div>
            <div class="mb-3">
                <label for="lozinka2" class="form-label"><i class="fa-solid fa-lock"></i> Potvrdi lozinku</label>
                <input type="password" name="lozinka2" class="form-control" id="lozinka2" placeholder="Ponovo unesite lozinku" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-primary">Registruj se</button>
        </form>
        <p class="mt-2">Već imate nalog? <a href="#" onclick="showLogin()">Prijavite se</a></p>
    </div>


    <!-- Prijava -->
    <div id="login-form" style="display:<?php echo (isset($_GET['form']) && $_GET['form']=="login") ? 'block' : 'none'; ?>;">
        <h2 class="display-4">Prijava</h2><hr>

              <!--provjera da li losa sifra ili da li postoji korisnik - prijava-->
          <?php
          if(isset($_SESSION['error'])){
              echo '<div id="poruka" class="alert alert-danger">'.$_SESSION['error'].'</div>';
              unset($_SESSION['error']);
          }

          if(isset($_SESSION['success'])){
              echo '<div id="poruka" class="alert alert-success">'.$_SESSION['success'].'</div>';
              unset($_SESSION['success']);
          }
          ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="email-login" class="form-label"><i class="fa-solid fa-envelope"></i> Email</label>
                <input type="email" name="email" class="form-control" id="email-login" value="<?php echo htmlspecialchars($form_data['email']); ?>" placeholder="Unesite email" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="lozinka-login" class="form-label"><i class="fa-solid fa-lock"></i> Lozinka</label>
                <input type="password" name="lozinka" class="form-control" id="lozinka-login" placeholder="Unesite lozinku" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-primary">Prijavi se</button>
        </form>
        <p class="mt-2">Nemate nalog? <a href="#" onclick="showRegister()">Registrujte se</a></p>
    </div>
</div>

<!-- JavaScript za toggle -->
<script>
function showLogin() {
    document.getElementById('register-form').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';
}

function showRegister() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
}
</script>

<!-- posto mi je forma sakrivena moram ovo da imam da bi se pojavila-->
<?php if(isset($_GET['login_error'])): ?>
<script>
    showLogin();
</script>
<?php endif; ?>
  

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
           <i class="textfooter">  Zlatara Koral - Mesto gde ćete pronaći nakit koji spaja bezvremensku eleganciju i vrhunski 
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


   <!-- da poruka o gresci tokom logina/registracije nestane posle 3 sekunde-->
   <script>
setTimeout(function(){
    let poruka = document.getElementById("poruka");
    if(poruka){
        poruka.style.display = "none";
    }
}, 3000);
</script>
  
   </body>
  </html>