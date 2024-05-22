<?php
session_start();
if (!isset($_SESSION["invalid_account"]) || !isset($_SESSION["invalid_request"])) {
  $_SESSION["invalid_account"] = 0; //inizializzazione variabile di sessione per validazione account
  $_SESSION["invalid_request"] = 0; //inizializzazione variabile di sessione per validazione richiesta pagina
}

//var_dump($_SESSION["invalid_account"]);
//var_dump($_SESSION["invalid_request"]);

//session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Pagina benvenuto</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/x-icon" href="images/logo.png">

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Honk&family=Orbitron&family=Freeman&family=Sedan+SC&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="css/bootstrap/bootstrap.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/jquery.fancybox.min.css">
  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/jquery.countdown.css" />
</head>

<body <?php
      if($_SESSION["invalid_request"] == -1){
        ?> onload="printInvalidRequest()" <?php
      }
      if ($_SESSION["invalid_account"] == 2){
        ?> onload="printDisconnessione()" <?php
      }
      if ($_SESSION["invalid_account"] == 3){
        ?> onload="printRimozione()" <?php
      }
      ?>>
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
            <a href="#">
              <img src="images/logo.png" alt="Logo">
            </a>
          </div>
          <div class="ml-auto">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                <li class="active"><a href="#" class="nav-link">Home</a></li>
                <li><a href="pages/selezione_evento/evento.php">Eventi</a></li>
                <li><a href="pages/serie_a/classifica.php" class="nav-link">Classifica Serie A 2023/2024</a></li>
                <li><a href="pages/serie_a/highlights.php" class="nav-link">Highlights Serie A 2023/2024</a></li>
                <?php
                if ($_SESSION['invalid_account'] == 1) {
                  echo '<li><a href="pages/dati_utente/utente.php?u=' . $_SESSION["utente"] . '" class="nav-link">Profilo utente</a></li>';
                } else {
                  echo '<li><a href="pages/login_registrazione/login.php" class="nav-link">Log-in</a></li>';
                }
                ?>
              </ul>
            </nav>

            <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right text-white"><span class="icon-menu h3 text-white"></span></a>
          </div>
        </div>
      </div>

    </header>

    <div class="hero overlay" style="background-image: url('images/coreografia_sfondo.jpg');">
      <div class="container">
        <div class="row align-items-center">
          <div class="col mx-auto text-center">
            <h1 class="text-purple">Gestionale ACF Fiorentina</h1>
            <p class="mt-5">
              <a href="#ultima" class="btn btn-primary py-3 px-4 mr-3">Ultima partita</a>
              <a href="#eventi" class="btn btn-primary py-3 px-4 mr-3">Eventi principali</a>
              <a href="#imminente" class="btn btn-primary py-3 px-4 mr-3">Evento imminente</a>
              <a href="#notizie" class="btn btn-primary py-3 px-4 mr-3">Ultime notizie</a>
            </p>
          </div>
        </div>
      </div>
    </div>



    <div class="container">
      <div class="row" id="ultima">
        <div class="col-12 title-section mt-5">
          <h2 class="heading"><a href="#" class="text-white">Ultima partita</a></h2>
        </div>
        <div class="col-lg-12">
          <div class="d-flex team-vs">
            <span class="score">#-#</span>
            <div class="team-1 w-50">
              <div class="team-details w-100 text-center">
                <a href="images/logo.png">
                  <img src="images/logo.png" alt="Image" class="img-fluid">
                </a>
                <h3>Fiorentina</h3>
                <ul class="list-unstyled">
                  <li>---</li>
                  <li>---</li>
                  <li>---</li>
                  <li>---</li>
                </ul>
              </div>
            </div>
            <div class="team-2 w-50">
              <div class="team-details w-100 text-center">
                <a href="images/logo_cagliari.png">
                  <img src="images/logo_cagliari.png" alt="Image" class="img-fluid">
                </a>
                <h3>Cagliari</h3>
                <ul class="list-unstyled">
                  <li>---</li>
                  <li>---</li>
                  <li>---</li>
                  <li>---</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="trasferte-principali">
      <div class="container">
        <div class="row" id="eventi">
          <div class="col-12 title-section">
            <h2 class="heading"><a href="#" class="text-white">Eventi principali</a></h2>
          </div>
        </div>
        <div class="row no-gutters">
          <div class="col-md-4">
            <div class="post-entry">
              <img src="images/semifinale_bruges.png" alt="Image" class="img-fluid">
              <div class="caption">
                <div class="caption-inner">
                  <h3 class="mb-3">Trasferta di Bruges, esultanza di Lucas Beltrán al goal in semifinale di Conference League 23/24</h3>
                  <div class="author d-flex align-items-center">
                    <div class="img mb-2 mr-3">
                      <a target="_blank" href="https://www.instagram.com/p/C6t8_iFuWM9/">
                        <img src="images/logo.png" alt="Image">
                      </a>
                    </div>
                    <div class="text">
                      <h4>Foto di <a target="_blank" href="https://www.instagram.com/acffiorentina/" class="text-lightblue">acffiorentina</a></h4>
                      <span>08 Maggio 2024, Bruges</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="post-entry">
              <img src="images/finale_conference.png" alt="Image" class="img-fluid">
              <div class="caption">
                <div class="caption-inner">
                  <h3 class="mb-3">Trasferta di Basilea, gol di Antonín Barák al termine della semifinale di Conference League 22/23</h3>
                  <div class="author d-flex align-items-center">
                    <div class="img mb-2 mr-3">
                      <a target="_blank" href="https://www.instagram.com/p/C7GvhDUC7CJ/">
                        <img src="images/999fiorentina.png" alt="Image">
                      </a>
                    </div>
                    <div class="text">
                      <h4>Foto di <a target="_blank" href="https://www.instagram.com/999_fiorentina/" class="text-lightblue">999_fiorentina</a></h4>
                      <span>18 Maggio 2023, Basilea</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="post-entry">
              <img src="images/finale_roma.png" alt="Image" class="img-fluid">
              <div class="caption">
                <div class="caption-inner">
                  <h3 class="mb-3">Trasferta di Roma, premiazione del capitano Cristiano Biraghi in seguito alla finale di Coppa Italia 22/23</h3>
                  <div class="author d-flex align-items-center">
                    <div class="img mb-2 mr-3">
                      <a target="_blank" href="https://www.instagram.com/p/C2Nnl9vCpy0/">
                        <img src="images/999fiorentina.png" alt="Image">
                      </a>
                    </div>
                    <div class="text">
                      <h4>Foto di <a target="_blank" href="https://www.instagram.com/999_fiorentina/" class="text-lightblue">999_fiorentina</a></h4>
                      <span>24 Maggio 2023, Roma</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="site-section bg-dark">
      <div class="container">
        <div class="row d-flex justify-content-center" id="imminente">
          <div class="col-12 title-section">
            <h2 class="heading"><a href="#" class="text-white">Evento imminente</a></h2>
          </div>
          <div class="col-lg-6">
            <div class="widget-next-match" style="background-image:url(images/conference.png)">
              <div class="widget-body mb-3">
                <div class="widget-vs">
                  <div class="d-flex align-items-center justify-content-around justify-content-between w-100">
                    <div class="team-1 text-center">
                      <a target="_blank" href="images/logo_olympiacos.png">
                        <img src="images/logo_olympiacos.png" alt="Image">
                      </a>
                      <h3>Olympiacos</h3>
                    </div>
                    <div>
                      <span class="vs"><span>VS</span></span>
                    </div>
                    <div class="team-2 text-center">
                      <a target="_blank" href="images/logo_fiorentina.png">
                        <img src="images/logo_fiorentina.png" alt="Image">
                      </a>
                      <h3>Fiorentina</h3>
                    </div>
                  </div>
                </div>
              </div>

              <div class="text-center widget-vs-contents mb-4">
                <h2 class="fw-bold"><b>Finale Conference League</b></h2>
                <p class="mb-5 pt-2 pb-1">
                  <span class="d-block text-white h4"><b>29 Maggio 2024</b></span>
                  <span class="d-block text-white h4"><b>21:00 CET</b></span>
                  <span class="d-block text-white h4"><b>AEK Arena, Atene</b></span>
                </p>
              </div>
              <div id="countdown"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container site-section">
      <div class="row" id="notizie">
        <div class="col-6 title-section">
          <h2 class="heading"><a href="#" class="text-white">Notizie principali</a></h2>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="custom-media d-flex">
            <a class="img mr-4" target="_blank" href="images/kouame.jpg">
              <img src="images/kouame.jpg" alt="Image" class="img-fluid">
            </a>
            <div class="text">
              <span class="meta">19 Maggio 2024</span>
              <h3 class="mb-4"><a target="_blank" href="https://www.labaroviola.com/uefa-severa-per-la-finale-di-atene-allo-stadio-sono-ammessi-solo-le-maglie-e-i-colori-di-fiorentina-e-olympiacos/253862/">UEFA severa per la finale di Atene</a></h3>
              <p>“Allo stadio sono ammessi solo le maglie e i colori di Fiorentina e Olympiacos”</p>
              <p><a target="_blank" href="https://www.labaroviola.com/uefa-severa-per-la-finale-di-atene-allo-stadio-sono-ammessi-solo-le-maglie-e-i-colori-di-fiorentina-e-olympiacos/253862/">Leggi di più</a></p>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="custom-media d-flex">
            <a class="img mr-4" target="_blank" href="images/maglia.jpg">
              <img src="images/maglia.jpg" alt="Image" class="img-news">
            </a>
            <div class="text">
              <span class="meta">16 Maggio 2024</span>
              <h3 class="mb-4"><a target="_blank" href="https://youtu.be/LNR9fceY2Aw">Fiorentina: ecco la maglia viola 2025 "L'anima Viola"</a></h3>
              <p>Il club viola ha presentato oggi la nuova maglia Home 2024/2025, realizzata in collaborazione con Kappa</p>
              <p><a target="_blank" href="https://youtu.be/LNR9fceY2Aw">Scopri di più</a></p>
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
              <h3><b>Profilo ufficiale</b></h3>
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
              <h3><b>Biglietti eventi</b></h3>
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
              <h3><b>Stagione 23/24</b></h3>
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
              <h3><b>Canali Social</b></h3>
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

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-migrate-3.0.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.stellar.min.js"></script>
  <script src="js/jquery.countdown.min.js"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/jquery.mb.YTPlayer.min.js"></script>
  <script src="js/main.js"></script>
  <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.countdown.js"></script>
	<script src="js/script.js"></script>
  <script>
    function printInvalidRequest() {
      alert("Attenzione, la pagina utente non è disponibile se non si è loggati!");
      <?php
      $_SESSION["invalid_request"] = 0;
      ?>
    }
    function printDisconnessione() {
      alert("Disconnessione avvenuta con successo, forza viola!");
      <?php
      if($_SESSION["invalid_account"] == 2){
        $_SESSION["invalid_account"] = 0;
      }
      ?>
    }
    function printRimozione() {
      alert("Rimozione avvenuta con successo, forza viola!");
      <?php
      if($_SESSION["invalid_account"] == 3){
        $_SESSION["invalid_account"] = 0;
      }
      ?>
    }
  </script>
</body>
</html>

<?php
function stampaDati($count, $row_squadra)
{
  echo "     
    <td>" . $count . "</td>
    <td>" . $row_squadra->nome . "</td>
    <td>" . $row_squadra->partite_giocate . "</td>
    <td>" . $row_squadra->vittorie . "</td>
    <td>" . $row_squadra->pareggi . "</td>
    <td>" . $row_squadra->sconfitte . "</td>
    <td>" . $row_squadra->goal_fatti . "</td>
    <td>" . $row_squadra->goal_subiti . "</td>
    <td>" . $row_squadra->numero_punti . "</td>";
}
?>