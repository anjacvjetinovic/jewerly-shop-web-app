
<?php

if(isset($_SESSION['uloga'])){
    echo "Uloga: " . $_SESSION['uloga'];
}
?>

<?php
session_start();

if(isset($_SESSION['korisnicki_id'])){
    echo "Prijavljen si kao ID: " . $_SESSION['korisnicki_id'];
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
 <meta name="keywords" content="Fruitables, Voce, Povrce, Organski
proizvodi">
 <meta name="author" content="Ime i prezime, e-mail">
 <title>Zlatara "Koral"</title>

 <link href="./css/bootstrap.min.css" rel="stylesheet"> <!--bootstrap--> 
 <link rel="stylesheet" href="./style.css">   <!--moj stil-->
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
          <?php if(isset($_SESSION['korisnik_id'])): ?> <!--da li postoji session promenljiva korisnik_id-->
            <!-- Korisnik prijavljen → korpa -->
            <a class="nav-link" href="korpa.php"><i class="fa-solid fa-cart-shopping fa-2x"></i>
              <!--AJAX BR PROIZVODA U KORPI-->
              <span id="broj-korpe" class="badge bg-danger">
                <?php echo isset($_SESSION['korpa']) ? count($_SESSION['korpa']) : 0; ?>
              </span>
            </a>
          <?php else: ?>
            <!-- Gost → omiljeni -->
            <a class="nav-link" href="omiljeni.php">
                <i class="fa-regular fa-heart fa-2x"></i>
            </a>
          <?php endif; ?>

          </li>
          <!--ako je prijavljen prikazi log out dugme-->
          <li class="nav-item">
          <!--<a class="nav-link" href="nalog.php"><i class="fa-solid fa-user fa-2x"></i></a></li>-->
            <?php if(isset($_SESSION['korisnik_id'])): ?>
              <a class="nav-link" href="logout.php">
                  <i class="fa-solid fa-right-from-bracket fa-2x"></i>
              </a>
            <!--ako nije prijavljen prikazi login/nalog stranicu-->
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

  <!-- slide show od slika -->
  <br>
  <div id="carouselExample" class="carousel slide">
   <div class="carousel-inner">
     <div class="carousel-item active">
       <a href="https://www.pandorashop.ba/ba/nakit-za-graviranje" target="_blank"><img src="./slike/pocetak1.png" class="d-block w-100 fixed-height" alt="Slika1"></a>
     </div>
     <div class="carousel-item">
       <a href="galerija.html" target="_blank"><img src="./slike/pocetak2.jpg" class="d-block w-100 fixed-height " alt="Slika2"></a>
     </div>
     <div class="carousel-item">
       <a href="ponuda.html" target="_blank"><img src="./slike/pocetak3.png" class="d-block w-100 fixed-height" alt="Slika3"></a>
     </div>
   </div>
   <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
     <span class="visually-hidden">Prethodna</span>
   </button>
   <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
     <span class="carousel-control-next-icon" aria-hidden="true"></span>
     <span class="visually-hidden">Sledeca</span>
   </button>
 </div>

  <br>
    <div class="naslov"> <h1><span>Dobro</span> <span> došli</span> <span>  na</span> <span>  sajt</span> <span>  zlatare Koral!</span> </h1>
      <h3>Nakit koji govori više od reči!</h3>
      <hr>
    </div>

    <!-- container 1 -->
  <br>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-4 d-flex align-items-stretch">
          <div class="card h-100">
            <img src="./slike/logo.jpeg" class="card-img-top" alt="Koral" style="width: 100%; height: 300px;">
            <div class="card-body">
              <h5 class="card-title">O nama</h5>
              <hr>
              <p class="card-text">
                <i><strong> <mark style="background-color: rgb(183,110,121);">Zlatara Koral </mark></strong>  je mesto gde verujemo da nakit nije samo ukras, vec odraz stila i ličnosti.
                Nudimo ekskluzivne ženske ogrlice, narukvice i prstenje izrađene od najfinijih materijala, sa dizajnom
                koji spaja eleganciju i savremeni šarm. <strong>Svaki komad je priča o luksuzu, sofisticiranosti i pažnji prema detalju - 
                stvoren da zasija zajedno sa Vama.</strong> </i>
              </p>
              <a href="onama.html" class="btn btn-success" target="_blank">O nama</a>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-4 d-flex align-items-stretch">
          <div class="card h-100">
            <img src="./slike/goldgram.png" class="card-img-top" alt="SaNamaSeZavrsava" style="width: 100%; height: 300px;">
            <div class="card-body">
              <h5 class="card-title">Goldgram</h5>
              <hr>
              <p class="card-text">
                Elegancija i prestiž sjedinjuju se u unikatnim karticama s 24-karatnim zlatom (995 finoće). 
                Svaka kartica je ekskluzivni kolekcionarski predmet, izrađen s izuzetnom preciznošću, a istovremeno 
                predstavlja i vrednu investiciju. Omogućena je potpuna personalizacija, kako bi Vaša 
                kartica bila jedinstvena i nezaboravna.
              </p>
              <a href="https://jewelleryroom.ba/store/goldgram/goldgram-investicijsko-zlato/" class="btn btn-success" target="_blank">Pogledaj ponudu</a>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-4 d-flex align-items-stretch">
          <div class="card h-100">
            <img src="./slike/giftCard.png" class="card-img-top" alt="AgataKristi" style="width: 100%; height: 300px;">
            <div class="card-body">
              <h5 class="card-title">Poklon vaučeri</h5>
              <hr>
              <p class="card-text">
                Obradujte svoje najmilije elegancijom i luksuzom! Ovaj vaučer omogućava izbor prelepog nakita po sopstvenoj želji – 
                od zlatnih ogrlica, prstenja, do unikatnih komada s 24-karatnim zlatom. Savršen poklon za svaku priliku, 
                koji spaja stil, prestiž i nezaboravno iskustvo.<i>Vaučer važi za sve artikle u našoj zlatarni i 
                može biti personalizovan po želji.</i> 
              </p>
              <a href="https://jadejewellers.com.au/products/jade-jewellers-gift-cards-1" class="btn btn-success" target="_blank">Više</a>
            </div>
          </div>
        </div>

      </div>
    </div>

  </section>

  <hr>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-12">
    <br>
   <div class="card mb-3">
    <div class="row g-0">
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title"><br><br><mark style="background: rgb(183,110,121);">Najprodavanije</mark></h5>
          <p class="card-text">Izdvajamo najprodavanije proizvode u 2024. godini.<br> Pogledajte celu kolekciju
            i uverite se zasto smo najbolji!
          </p>
        </div>
      </div>
      <div class="col-md-4">
        <a href="aktuelno.html" target="_blank">
          <img src="./slike/sve1.png" class="img-fluid roundedstart" alt="sve">
        </a>
  
      </div>
    </div>
  </div>
   <br>
  </div>
  </section>


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
         <i class="textfooter">  Zlatara Koral - Mesto gde ćete pronaci nakit koji spaja bezvremensku eleganciju i vrhunski 
          kvalitet za svaku priliku. Svaki komad je pažljivo izabran kako bi ulepsao Vase posebne trenutke i trajao celi život.
          Nakit koji govori više od rei!</p>
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

 </body>
</html>