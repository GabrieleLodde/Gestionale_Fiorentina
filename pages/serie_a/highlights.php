<?php
session_start();
require_once("../../databases/database_partite/Mysingleton.php");
$connection = Mysingleton::getInstance();
$query_risultati = "SELECT * FROM Risultati";
$sth_risultati = $connection->prepare($query_risultati);
$sth_risultati->execute();

$query_squadre = "SELECT id_squadra, nome FROM Squadre";
$sth_squadre = $connection->prepare($query_squadre);
$sth_squadre->execute();

//controllo per cambiare il valore della variabile di sessione inerente alla modifica dei dati dell'utente, 
// perchè qualora un utente selezioni questa pagina, avendo in precedenza l'intenzione di modificare i propri dati,
// una volta che ritorna nel proprio profilo non deve visualizzare i dati modificabili, bensì fissi
if(isset($_SESSION["modifica_account"])){
    if($_SESSION["modifica_account"] == 1){
        $_SESSION["modifica_account"] = 0;
    }
}
//var_dump($_SESSION["invalid_account"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pagina highlights</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="../../images/logo.png">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron&family=Freeman&family=Sedan+SC&family=Sixtyfour&family=Silkscreen&family=Bebas+Neue&display=swap" rel="stylesheet">
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
                                <?php 
                                if($_SESSION["visualizza_catalogo"] == 1){
                                    echo '<li><a href="../selezione_catalogo/catalogo.php" class="nav-link">Catalogo</a></li>';
                                }?>
                                <li><a href="classifica.php" class="nav-link">Classifica Serie A 2023/2024</a></li>
                                <li class="active"><a href="#" class="nav-link">Highlights Serie A 2023/2024</a></li>
                                <?php
                                if ($_SESSION['invalid_account'] == 1) {
                                    echo '<li><a href="../dati_utente/utente.php?u=' . $_SESSION["utente"] . '" class="nav-link">Profilo utente</a></li>';
                                } else {
                                    echo '<li><a href="../login_registrazione/login.php" class="nav-link">Log-in</a></li>';
                                }
                                ?>
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
                        <h1 class="text-purple">Highlights Serie A TIM 2023/2024</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-section">
            <div class="container">
                <div class="row">
                    <div class="col col-xxl-6">
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
                                        <a href='$row_risultato->link_highlights'>
                                            <img src='$row_risultato->image_partita' alt='Image' class='img-carousel'>
                                        </a>
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
</body>
</html>