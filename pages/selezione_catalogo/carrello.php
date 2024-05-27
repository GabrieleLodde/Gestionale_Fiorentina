<?php
session_start();
require_once("../../databases/database_progetto/Mysingleton1.php");
$connection = Mysingleton1::getInstance();
$empty = false;
$nome_cookie = "carrello_articoli_per_" . $_SESSION["utente"];

if ($_COOKIE[$nome_cookie] == "vuoto") {
    $empty = true;
} else {
    if (!isset($_SESSION["token"])) {
        $_SESSION["token"] = bin2hex(random_bytes(32)); //generazione token per evitare che il contatore degli articoli si incrementi al refresh
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["token"]) && hash_equals($_SESSION["token"], $_POST["token"])) {
        $key = array_search($_POST["id_articolo"], $_SESSION["articoli"]);
        if ($key !== false) {
            array_splice($_SESSION["articoli"], $key, 1);
        }
        $stringa_array = implode(",", $_SESSION["articoli"]);
        $_SESSION["count_articoli"] = count($_SESSION["articoli"]); //Aggiorno il numero di articoli considerata l'avvenuta rimozione
        if ($_SESSION["count_articoli"] == 0) {
            $stringa_vuoto = "vuoto";
            setcookie($nome_cookie, $stringa_vuoto, time() + (86400 * 30), "/");
        } else {
            //Aggiorno il valore del cookie considerata la rimozione di un articolo dal carrello
            $id_articoli_aggiornati = $_SESSION["articoli"];
            setcookie($nome_cookie, implode(",", $id_articoli_aggiornati), time() + (86400 * 30), "/");
        }
        $_SESSION["token"] = bin2hex(random_bytes(32)); //Genero un nuovo valore del token dopo ogni POST per evitare duplicati
    }

    if (count($_SESSION["articoli"]) == 1) {
        $id_articoli = implode(",",$_SESSION["articoli"]);
        $query_articoli = " SELECT A.Id_articolo, A.descrizione_articolo, A.prezzo_base, ROUND((A.prezzo_base -(A.prezzo_base/100 * S.valore)), 2) as prezzo_scontato, A.tipo, A.immagine, S.Id_sconto, S.valore  
                            FROM Articolo A 
                            INNER JOIN Sconto S ON A.Id_sconto = S.Id_sconto
                            WHERE A.Id_articolo = :id_articolo";
        $sth_articoli = $connection->prepare($query_articoli);
        $sth_articoli->bindParam(":id_articolo", $id_articoli, PDO::PARAM_INT);
        $sth_articoli->execute();
    } else if (count($_SESSION["articoli"]) != 1 && count($_SESSION["articoli"]) != 0) {
        $id_articoli = $_SESSION["articoli"];
        sort($id_articoli);
        $query_articoli = "";
        foreach ($id_articoli as $id) {
            $query_articoli .= "SELECT A.Id_articolo, A.descrizione_articolo, A.prezzo_base, ROUND((A.prezzo_base -(A.prezzo_base/100 * S.valore)), 2) as prezzo_scontato, A.tipo, A.immagine, S.Id_sconto, S.valore  
                                FROM Articolo A 
                                INNER JOIN Sconto S ON A.Id_sconto = S.Id_sconto
                                WHERE A.Id_articolo = $id
                                UNION ALL ";
        }
        // Rimuovi l'ultima "UNION ALL" dalla query
        $query_articoli = rtrim($query_articoli, "UNION ALL ");
        $sth_articoli = $connection->prepare($query_articoli);
        $sth_articoli->execute();
    }
    else{
        $empty = true;
    }
}
$query_nome = " SELECT nome
                FROM Utente
                WHERE Id_utente = :id_utente";
$sth_nome = $connection->prepare($query_nome);
$sth_nome->bindParam(':id_utente', $_SESSION["utente"], PDO::PARAM_INT);
$sth_nome->execute();
$row_nome = $sth_nome->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pagina catalogo</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
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
                                <li class="active"><a href="#" class="nav-link">Carrello</a></li>
                                <li><a href="../serie_a/classifica.php" class="nav-link">Classifica Serie A 2023/2024</a></li>
                                <li><a href="../serie_a/highlights.php" class="nav-link">Highlights Serie A 2023/2024</a></li>
                                <li><a href="../dati_utente/utente.php?u=<?php echo $_SESSION["utente"] ?>" class="nav-link">Profilo utente</a></li>
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
                        <h1 class="text-purple">Carrello di <?php echo $row_nome->nome ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="d-flex flex-row-reverse">
                    <a href="catalogo.php" class="d-inline-block btn-outline-dark border border-white pl-3 pr-3 mb-3 custom-btn">
                        <i class="bi bi-shop"></i>
                        Visualizza catalogo
                    </a>
                </div>
                <?php
                if ($empty) { ?>
                    <div class="spacer d-flex justify-content-center align-items-center text-center">
                        <h1>Il tuo carrello è vuoto!</h1>
                    </div>
                <?php
                } else { ?>
                    <form action="../selezione_pagamento/pagamento.php" class="d-flex flex-row-reverse">
                        <button class="btn-outline-dark border border-white pl-3 pr-3 mb-5 custom-btn" type="submit">
                            <i class="bi bi-credit-card"></i>
                            Procedi al pagamento
                        </button>
                    </form>
                    <?php
                    $num_articoli = $sth_articoli->rowCount();
                    $count_articoli = 0;
                    $count_per_riga = 0;
                    $first_time = true;
                    while ($row_articolo = $sth_articoli->fetch(PDO::FETCH_OBJ)) {
                        $count_articoli++;
                        if ($first_time) {
                            $first_time = false; ?>
                            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
                            <?php
                        }
                        if ($count_per_riga >= 3) { ?>
                            </div>
                            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
                            <?php
                            $count_per_riga = 0;
                        }
                        $count_per_riga++;
                            ?>
                            <div class="col-lg-4 col-md-6 mb-5">
                                <div class="card h-100">
                                    <?php
                                    if ($row_articolo->Id_sconto != 4) { ?>
                                        <!-- Sale badge-->
                                        <div class="badge bg-dark text-white position-absolute mb-5 pt-2 pb-2 pl-2 pr-2" style="top: 0.5rem; right: 0.5rem">Sconto <?php echo $row_articolo->valore . "%" ?> !</div>
                                    <?php
                                    }
                                    ?>
                                    <!-- Product image-->
                                    <img class="card-img-top" src="<?php echo $row_articolo->immagine ?>" alt="..." />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder text-black" data-html="true"><?php echo $row_articolo->descrizione_articolo ?></h5>
                                            <?php if ($row_articolo->Id_sconto != 4) { ?>
                                                <!-- Product price without discount-->
                                                <span class="text-muted text-decoration-line-through"><?php echo $row_articolo->prezzo_base .  "€" ?></span>
                                            <?php
                                            } ?>
                                            <!-- Product price with scount-->
                                            <span class="text-danger"><?php echo $row_articolo->prezzo_scontato .  "€" ?></span>
                                            <br>
                                            <?php
                                            $query_taglie = "   SELECT T.descrizione_taglia
                                                                FROM Articolo A INNER JOIN ArticoloTaglia ART ON A.Id_articolo = ART.Id_articolo
                                                                INNER JOIN Taglia T ON ART.Id_taglia = T.Id_taglia
                                                                WHERE A.Id_articolo = :id_articolo";
                                            $sth_taglie = $connection->prepare($query_taglie);
                                            $sth_taglie->bindParam(":id_articolo", $row_articolo->Id_articolo, PDO::PARAM_INT);
                                            $sth_taglie->execute();
                                            $num_taglie = $sth_taglie->rowCount();
                                            $count_taglie = 0;
                                            $stringa_taglie = "";
                                            $first_time_taglia = true;
                                            while ($row_taglia = $sth_taglie->fetch(PDO::FETCH_OBJ)) {
                                                $count_taglie++;
                                                if ($num_taglie == 1) {
                                                    $stringa_taglie =  $row_taglia->descrizione_taglia;
                                                    break;
                                                }
                                                if ($first_time_taglia == true) {
                                                    $stringa_taglie =  $row_taglia->descrizione_taglia . " - ";
                                                    $first_time_taglia = false;
                                                } else if ($first_time_taglia == false && $num_taglie != $count_taglie) {
                                                    $stringa_taglie = $stringa_taglie . $row_taglia->descrizione_taglia . " - ";
                                                } else if ($num_taglie == $count_taglie) {
                                                    $stringa_taglie = $stringa_taglie . $row_taglia->descrizione_taglia;
                                                }
                                            }
                                            ?>
                                            <span class="text-purple"><?php echo $stringa_taglie ?></span>
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center">
                                            <form action="carrello.php" method="post">
                                                <input type="hidden" name="id_articolo" value="<?php echo $row_articolo->Id_articolo ?>">
                                                <input type="hidden" name="token" value="<?php echo $_SESSION["token"]; ?>">
                                                <input class="btn btn-outline-dark mt-auto" type="submit" value="Rimuovi dal carrello"></input>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($count_articoli == $num_articoli) { ?>
                            </div>
                <?php
                            }
                        }
                    } ?>
            </div>
        </section>

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
    <!-- .site-wrap -->
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