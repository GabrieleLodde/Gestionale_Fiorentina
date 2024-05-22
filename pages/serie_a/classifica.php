<?php
session_start();
require_once("../../databases/database_partite/Mysingleton.php");
$connection = Mysingleton::getInstance();
$select_classifica = "SELECT * 
                      FROM Squadre 
                      ORDER BY numero_punti DESC, differenza_reti DESC, goal_fatti DESC";
$sth_classifica = $connection->prepare($select_classifica);
$sth_classifica->execute();

//var_dump($_SESSION["invalid_account"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pagina log-in</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="../../images/logo.png">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Orbitron&family=Freeman&family=Josefin+Slab:ital,wght@0,100..700;1,100..700&family=Sixtyfour&family=Silkscreen&family=Bebas+Neue&display=swap" rel="stylesheet">
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
                                <li class="active"><a href="#" class="nav-link">Classifica Serie A 2023/2024</a></li>
                                <li><a href="highlights.php" class="nav-link">Highlights Serie A 2023/2024</a></li>
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
                        <h1 class="text-purple">Classifica Serie A TIM 2023/2024</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="site-section">
            <div class="container">
                <div class="col-12 title-section mt-5 text-right">
                    <a title="Legenda" data-html="true" data-toggle="popover" data-trigger="hover" data-placement="top"
                        data-content="
                        <div>
                            Champions League = Giallo<br><br>
                            Europa League = Arancione<br><br>
                            Conference League = Verde<br><br>
                            Retrocessione = Rosso
                        </div>">
                        <button type="button" id="button-popover">Visualizza legenda</button>
                    </a>
                </div>
                <div class="row align-items-center">
                    <div class="col mx-auto text-center" style="overflow-x:auto;">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th title="POSIZIONAMENTO"><b>POS</b></th>
                                    <th title="LOGO SQUADRA"><b>LOGO</b></th>
                                    <th title="NOME SQUADRA"><b>Squadra</b></th>
                                    <th title="PARTITE GIOCATE"><b>PG</b></th>
                                    <th title="VITTORIE"><b>V</b></th>
                                    <th title="PAREGGI"><b>P</b></th>
                                    <th title="SCONFITTE"><b>S</b></th>
                                    <th title="GOAL FATTI"><b>GF</b></th>
                                    <th title="GOAL SUBITI"><b>GS</b></th>
                                    <th title="DIFFERENZA RETI"><b>DR</b></th>
                                    <th title="PUNTI"><b>PTS</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                while (($row_squadra = $sth_classifica->fetch(PDO::FETCH_OBJ))) {
                                    $count++;
                                    if ($count <= 5) {
                                        echo "<tr class='champions_league'>";
                                        stampaDati($count, $row_squadra);
                                        echo "</tr>";
                                    } else if ($count >= 6 && $count <= 7) {
                                        echo "<tr class='europa_league'>";
                                        stampaDati($count, $row_squadra);
                                        echo "</tr>";
                                    } else if ($count == 8) {
                                        echo "<tr class='conference_league'>";
                                        stampaDati($count, $row_squadra);
                                        echo "</tr>";
                                    } else if ($count >= 18 && $count <= 20) {
                                        echo "<tr class='retrocessione'>";
                                        stampaDati($count, $row_squadra);
                                        echo "</tr>";
                                    } else {
                                        echo "<tr class='normale'>";
                                        stampaDati($count, $row_squadra);
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

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
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
        });
    </script>
</body>

</html>

<?php
function stampaDati($count, $row_squadra)
{
    $squadra = strtoupper($row_squadra->nome);
    echo "     
    <td>" . $count . "</td>
    <td><img src='" . $row_squadra->logo_squadra . "' alt='logo_squadra'></td>
    <td title=\"$squadra\">" . $row_squadra->nome . "</td>
    <td>" . $row_squadra->partite_giocate . "</td>
    <td>" . $row_squadra->vittorie . "</td>
    <td>" . $row_squadra->pareggi . "</td>
    <td>" . $row_squadra->sconfitte . "</td>
    <td>" . $row_squadra->goal_fatti . "</td>
    <td>" . $row_squadra->goal_subiti . "</td>
    <td>" . $row_squadra->differenza_reti . "</td>
    <td>" . $row_squadra->numero_punti . "</td>";
}
?>