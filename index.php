<?php
require_once("databases/database_partite/Mysingleton.php");
$connection = Mysingleton::getInstance();
$query_risultati = "SELECT * FROM Risultati";
$sth_risultati = $connection->prepare($query_risultati);
$sth_risultati->execute();

$query_squadre = "SELECT id_squadra, nome FROM Squadre";
$sth_squadre = $connection->prepare($query_squadre);
$sth_squadre->execute();
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
            <a href="#">
              <img src="images/logo.png" alt="Logo">
            </a>
          </div>
          <div class="ml-auto">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                <li class="active"><a href="index.html">Home</a></li>
                <li><a href="#">Eventi</a></li>
                <li><a href="#">---</a></li>
                <li><a href="#">---</a></li>
                <li><a href="pages/login_registrazione/login.php">Log-in</a></li>
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
            <h1 class="text-purple">Gestione trasferte Fiorentina</h1>
            <div id="date-countdown"></div>
            <p>
              <a href="pages/login_registrazione/login.php" class="btn btn-primary py-3 px-4 mr-3">Compra un biglietto</a>
              <a href="#highlights" class="btn btn-primary py-3 px-4 mr-3">Highlights Serie A 23/24</a>
            </p>
          </div>
        </div>
      </div>
    </div>



    <div class="container">
      <div class="row">
        <div class="col-12 title-section mt-5">
          <h2 class="heading">Ultima partita</h2>
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
        <div class="row">
          <div class="col-12 title-section">
            <h2 class="heading">Trasferte principali</h2>
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
        <div class="row">
          <div class="col-lg-6">
            <div class="widget-next-match" style="background-image:url(images/conference.png)">
              <div class="widget-title">
                <h3>Prossima partita</h3>
              </div>
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
                <h4><b>Conference League</b></h4>
                <p class="mb-5 pt-2 pb-3" style="background-color:red;">
                  <span class="d-block text-white"><b>29 Maggio 2024</b></span>
                  <span class="d-block text-white"><b>21:00 CET</b></span>
                  <strong class="text-white">AEK Arena, Atene</strong>
                </p>

                <div id="date-countdown2" class="pb-1"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">

            <div class="widget-next-match">
              <table class="table custom-table">
                <thead>
                  <tr>
                    <th>P</th>
                    <th>Team</th>
                    <th>W</th>
                    <th>D</th>
                    <th>L</th>
                    <th>PTS</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td><strong class="text-white">Football League</strong></td>
                    <td>22</td>
                    <td>3</td>
                    <td>2</td>
                    <td>140</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td><strong class="text-white">Soccer</strong></td>
                    <td>22</td>
                    <td>3</td>
                    <td>2</td>
                    <td>140</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td><strong class="text-white">Juvendo</strong></td>
                    <td>22</td>
                    <td>3</td>
                    <td>2</td>
                    <td>140</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td><strong class="text-white">French Football League</strong></td>
                    <td>22</td>
                    <td>3</td>
                    <td>2</td>
                    <td>140</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td><strong class="text-white">Legia Abante</strong></td>
                    <td>22</td>
                    <td>3</td>
                    <td>2</td>
                    <td>140</td>
                  </tr>
                  <tr>
                    <td>6</td>
                    <td><strong class="text-white">Gliwice League</strong></td>
                    <td>22</td>
                    <td>3</td>
                    <td>2</td>
                    <td>140</td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <td><strong class="text-white">Cornika</strong></td>
                    <td>22</td>
                    <td>3</td>
                    <td>2</td>
                    <td>140</td>
                  </tr>
                  <tr>
                    <td>8</td>
                    <td><strong class="text-white">Gravity Smash</strong></td>
                    <td>22</td>
                    <td>3</td>
                    <td>2</td>
                    <td>140</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-6 title-section" id="highlights">
            <h2 class="heading">Highlights Serie A TIM 2023/2024</h2>
          </div>
          <div class="col-6 text-right">
            <div class="custom-nav">
              <a href="#" class="js-custom-prev-v2"><span class="icon-keyboard_arrow_left"></span></a>
              <span></span>
              <a href="#" class="js-custom-next-v2"><span class="icon-keyboard_arrow_right"></span></a>
            </div>
          </div>
        </div>
        <div class="owl-4-slider owl-carousel">
          <?php
          while ($row_risultato = $sth_risultati->fetch(PDO::FETCH_OBJ)) {
            $squadra_casa = "";
            $squadra_ospite = "";
            $sth_squadre->execute();
            while ($row_squadra = $sth_squadre->fetch(PDO::FETCH_OBJ)) {
              if ($row_risultato->id_squadra_casa == $row_squadra->id_squadra) {
                $squadra_casa = $row_squadra->nome . " " . $row_risultato->numero_goal_casa;
              } else if ($row_risultato->id_squadra_ospite == $row_squadra->id_squadra) {
                $squadra_ospite = $row_squadra->nome . " " . $row_risultato->numero_goal_ospite;
              }
            }
            echo "  <div class='item'>
                      <div class='video-media'>
                        <img src='$row_risultato->image_partita' alt='Image' class='img-carousel'>
                        <a href='$row_risultato->link_highlights' class='d-flex play-button align-items-center' data-fancybox>
                          <span class='icon mr-3'>
                            <span class='icon-play'></span>
                          </span>
                            <div class='caption'>
                              <h3><b>$squadra_casa<br>$squadra_ospite</b></h3>
                            </div>
                        </a>
                      </div>
                    </div>";
          }
          ?>
        </div>
      </div>
    </div>

    <div class="container site-section">
      <div class="row">
        <div class="col-6 title-section">
          <h2 class="heading">Notizie principali</h2>
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
              <img src="images/maglia.jpg" alt="Image" class="img-fluid">
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
  <!-- .site-wrap -->
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
</body>

</html>