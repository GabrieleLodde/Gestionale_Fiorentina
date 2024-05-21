<?php
//gestione profilo utente
//sloggarsi (uscita sessione)
//eliminare account (eliminazione account)
//visualizzare pagina con query string composta da: url + id_utente --> per visualizzare i dati di un utente (in sessione)
//questa pagina deve essere vista solo se $_SESSION["invalid_account"] == 1
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Pagina utente</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="../../images/logo.png">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron&family=Freeman&family=Sedan+SC&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../fonts/icomoon/style.css">
  <link rel="stylesheet" href="../../css/bootstrap/bootstrap.css">
  <link rel="stylesheet" href="../../css/jquery-ui.css">
  <link rel="stylesheet" href="../../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../../css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="../../css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="../../fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="../../css/aos.css">
  <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
  <div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>


    <header class="site-navbar py-4" role="banner">

      <div class="container">
        <div class="d-flex align-items-center">
          <div class="site-logo">
            <a href="../../index.php">
              <img src="../../images/logo.png" alt="Logo">
            </a>
          </div>
          <div class="ml-auto">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                <li><a href="../../index.php" class="nav-link">Home</a></li>
                <li><a href="../selezione_evento/evento.php" class="nav-link">Eventi</a></li>
                <li><a href="../serie_a/classifica.php">Classifica Serie A 2023/2024</a></li>
                <li><a href="../serie_a/highlights.php">Highlights Serie A 2023/2024</a></li>
                <li class="active"><a href="#" class="nav-link">Profilo Utente</a></li>
              </ul>
            </nav>

            <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right text-white"><span class="icon-menu h3 text-white"></span></a>
          </div>
        </div>
      </div>

    </header>

    <div class="hero overlay" style="background-image: url('../../images/coreografia_sfondo.jpg');">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-9 mx-auto text-center">
            <h1 class="text-purple">Profilo utente</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <form action="checkInput.php" method="post">
              <div class="form-group">
                <input type="email" name="email_login" placeholder="Email" class="form-control" required>
              </div>
              <div class="form-group">
                <input type="password" name="password_login" placeholder="Password" class="form-control" required>
              </div>
              <div class="form-group">
                <input type="submit" value="Log-in" class="btn btn-primary py-3 px-5">
                <input type="reset" value="Annulla log-in" class="btn btn-primary py-3 px-5">
              </div>
              <div class="form-group">
                Non hai effettuato la registrazione? <a href="registrazione.php">Clicca qui</a>
              </div>
            </form>
          </div>
          <div class="col-lg-4 ml-auto">
            <div class="img mb-4">
              <a target="_blank" href="../../images/curva_viola.jpg"><img src="../../images/curva_viola.jpg" alt="Image" class="img-base"></a>
            </div>
          </div>
        </div>
      </div>
    </div>


    <footer class="footer-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <div class="widget mb-3">
              <h3>Profilo ufficiale</h3>
              <ul class="list-unstyled links">
                <li><a target="_blank" href="https://www.acffiorentina.com/it">Sito ufficiale Fiorentina</a></li>
                <li><a target="_blank" href="https://www.acffiorentina.com/it/squadre/prima-squadra-maschile/tutti">Rosa del club maschile</a></li>
                <li><a target="_blank" href="https://www.acffiorentina.com/it/squadre/squadra-femminile/tutti">Rosa del club femminile</a></li>
                <li><a target="_blank" href="https://www.acffiorentina.com/it/contatti">Contatti del club</a></li>
                <li><a target="_blank" href="https://www.legaseriea.it/it/team/fiorentina/club">Organigramma del club</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="widget mb-3">
              <h3>Biglietti eventi</h3>
              <ul class="list-unstyled links">
                <li><a target="_blank" href="https://www.bigliettifiorentina.com/">Biglietteria online</a></li>
                <li><a target="_blank" href="https://www.bigliettifiorentina.com/corporate-hospitality/">Corporate hospitality</a></li>
                <li><a target="_blank" href="https://acffiorentina.vivaticket.it/it/fiorentinacard">Gift card</a></li>
                <li><a target="_blank" href="https://acffiorentina.vivaticket.it/index.php?nvpg[sellshow]&cmd=ShowTdtListType">Fidelity card</a></li>
                <li><a target="_blank" href="https://www.abbonamentifiorentina.com/">Abbonamenti</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="widget mb-3">
              <h3>Stagione 23/24</h3>
              <ul class="list-unstyled links">
                <li><a target="_blank" href="https://www.acffiorentina.com/it/stagione/calendario-e-risultati/serie-a/2023">Serie A</a></li>
                <li><a target="_blank" href="https://www.acffiorentina.com/it/stagione/calendario-e-risultati/coppa-italia/2023">Coppa Italia</a></li>
                <li><a target="_blank" href="https://www.acffiorentina.com/it/stagione/calendario-e-risultati/super-coppa/2023">Super Coppa Italiana</a></li>
                <li><a target="_blank" href="https://www.acffiorentina.com/it/stagione/calendario-e-risultati/conference-league/2023">Conference League</a></li>
                <li><a target="_blank" href="https://www.acffiorentina.com/it/news/tutte/prima-squadra-maschile/2023-07-03/stagione-2023-24-programma-amichevoli">Amichevoli estive</a></li>
              </ul>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="widget mb-3">
              <h3>Canali Social</h3>
              <ul class="list-unstyled links">
                <li><a target="_blank" href="https://www.facebook.com/ACFFiorentina/">Facebook</a></li>
                <li><a target="_blank" href="https://www.instagram.com/acffiorentina/">Instagram</a></li>
                <li><a target="_blank" href="https://x.com/acffiorentina">X</a></li>
                <li><a target="_blank" href="https://www.youtube.com/acffiorentina">Youtube</a></li>
                <li><a target="_blank" href="https://www.tiktok.com/@acffiorentina">TikTok</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>

  </div>

  <script src="../../js/jquery-3.3.1.min.js"></script>
  <script src="../../js/jquery-migrate-3.0.1.min.js"></script>
  <script src="../../js/jquery-ui.js"></script>
  <script src="../../js/popper.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/owl.carousel.min.js"></script>
  <script src="../../js/jquery.stellar.min.js"></script>
  <script src="../../js/jquery.countdown.min.js"></script>
  <script src="../../js/bootstrap-datepicker.min.js"></script>
  <script src="../../js/jquery.easing.1.3.js"></script>
  <script src="../../js/aos.js"></script>
  <script src="../../js/jquery.fancybox.min.js"></script>
  <script src="../../js/jquery.sticky.js"></script>
  <script src="../../js/jquery.mb.YTPlayer.min.js"></script>

  <script src="../../js/main.js"></script>
  <script>
    function printInvalidAccount() {
      alert("Credenziali non valide!");
      <?php
      $_SESSION["invalid_account"] = 0;
      ?>
    }
  </script>
</>
</html>