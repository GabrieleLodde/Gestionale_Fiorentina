<?php
session_start();
require_once("../../databases/database_progetto/Mysingleton1.php");
$connection = Mysingleton1::getInstance();
if (!isset($_SESSION["invalid_nome"])) {
    $_SESSION["invalid_nome"] = false;
}

$nome_cookie = "carrello_articoli_per_" . $_SESSION["utente"];
if ($_SESSION["count_articoli"] != 0 && $_COOKIE[$nome_cookie] != "vuoto") {
    $pagamento = 2; //inizializzazione della variabile per verificare se il pagamento è permesso o meno
    $id_articoli = $_SESSION["articoli"];
    $query_credito = "  SELECT credito 
                        FROM Utente 
                        WHERE Id_utente = :id_utente";
    $sth_credito = $connection->prepare($query_credito);
    $sth_credito->bindParam(":id_utente", $_SESSION["utente"], PDO::PARAM_INT);
    $sth_credito->execute();
    $row_credito = $sth_credito->fetch(PDO::FETCH_OBJ);
    $credito_utente = $row_credito->credito;

    $query_prezzi = "";
    foreach ($id_articoli as $id) {
        $query_prezzi .= "  SELECT ROUND((A.prezzo_base -(A.prezzo_base/100 * S.valore)), 2) as prezzo_scontato, CA.tipo_capo, A.descrizione_articolo, A.tipo
                            FROM Articolo A 
                            INNER JOIN Sconto S ON A.Id_sconto = S.Id_sconto
                            INNER JOIN CapoAbbigliamento CA ON A.Id_capo = CA.Id_capo
                            WHERE A.Id_articolo = $id
                            UNION ALL ";
    }
    // rimozione dell'ultima "UNION ALL" dalla query
    $query_prezzi = rtrim($query_prezzi, "UNION ALL ");
    $sth_prezzi = $connection->prepare($query_prezzi);
    $sth_prezzi->execute();
    $somma_prezzi = 0;
    while ($row_prezzi = $sth_prezzi->fetch(PDO::FETCH_OBJ)) {
        $somma_prezzi += $row_prezzi->prezzo_scontato;
    }
    $somma_prezzi_formattata = number_format($somma_prezzi, 2);
    if ($credito_utente >= $somma_prezzi && $credito_utente != 0) {
        $pagamento = 1;
    } else if($credito_utente < $somma_prezzi && $credito_utente != 0){
        $pagamento = -1;
    }
    else if($credito_utente == 0){
        $pagamento = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Pagina pagamento</title>
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

    <body   <?php
            if ($_SESSION["count_articoli"] == 0) {
            ?> onload="printInvalidVisualizzazione()" <?php
            } else if ($pagamento == -1) {
            ?> onload="printInvalidPagamento()" <?php
            } else if ($pagamento == 0) {
            ?> onload="printInvalidCredito()" <?php
            } else if ($_SESSION["invalid_nome"] == true) {
            ?> onload="printInvalidNome()" <?php
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
                            <a href="../../index.php">
                                <img src="../../images/logo.png" alt="Logo">
                            </a>
                        </div>
                        <div class="ml-auto">
                            <nav class="site-navigation position-relative text-right" role="navigation">
                                <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                                    <li><a href="../../index.php" class="nav-link">Home</a></li>
                                    <li class="active"><a href="#" class="nav-link">Pagamento</a></li>
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
                            <h1 class="text-purple">Pagamento articoli</h1>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container custom-container px-4 px-lg-5 mt-5 mb-5">
                <main>
                    <div class="container custom-container px-4 px-lg-5 mt-5">
                        <div class="row g-5 pt-3 pb-3">
                            <div class="col-12 d-flex flex-column align-items-end p-0">
                                <div class="mb-3">
                                    <a href="../selezione_catalogo/catalogo.php" class="btn btn-outline-dark border border-white pl-3 pr-3 custom-btn">
                                        <i class="bi bi-shop"></i>
                                        Visualizza catalogo
                                    </a>
                                </div>
                                <div class="mb-3">
                                    <form action="../selezione_catalogo/carrello.php">
                                        <button class="btn btn-outline-dark border border-white pl-3 pr-3 custom-btn" type="submit">
                                            <i class="bi-cart-fill me-1"></i>
                                            Visualizza carrello
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row g-5 p-3 border border-white rounded" style="border-width: 5px !important;">
                            <div class="col-md-6 col-lg-5 order-md-last">
                                <h4 class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-payment">Articoli carrello</span>
                                    <span class="badge bg-secondary rounded-pill p-2"><?php echo $_SESSION["count_articoli"]; ?></span>
                                </h4>
                                <ul class="list-group mb-3">
                                    <?php
                                    $sth_prezzi->execute();
                                    while ($row_articolo = $sth_prezzi->fetch(PDO::FETCH_OBJ)) { ?>
                                        <li class="list-group-item d-flex justify-content-between lh-sm">
                                            <div>
                                                <h6 class="my-0 text-black"><?php echo $row_articolo->tipo_capo; ?></h6>
                                                <small class="text-description">
                                                    <?php
                                                    $descrizione = $row_articolo->descrizione_articolo;
                                                    if (strpos($descrizione, "FIORENTINA MAGLIA GARA") !== false) {
                                                        $descrizione = "FIORENTINA MAGLIA GARA " . $row_articolo->tipo;
                                                    }
                                                    else if (strpos($descrizione, "FIORENTINA KIT HOME") !== false) {
                                                        $descrizione = "FIORENTINA KIT HOME";
                                                    }
                                                    else if (strpos($descrizione, "FIORENTINA MINIKIT") !== false) {
                                                        $descrizione = "FIORENTINA MINIKIT";
                                                    }
                                                    else if (strpos($descrizione, "FIORENTINA PANTALONCINI GARA") !== false) {
                                                        $descrizione = "FIORENTINA PANTALONCINI " . $row_articolo->tipo;
                                                    }
                                                    else if (strpos($descrizione, "FIORENTINA CALZETTONI GARA") !== false) {
                                                        $descrizione = "FIORENTINA CALZETTONI " . $row_articolo->tipo;
                                                    }
                                                    echo $descrizione;
                                                    ?>
                                                </small>
                                            </div>
                                            <span class="text-body-secondary text-price"><?php echo $row_articolo->prezzo_scontato . "€"; ?></span>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-sum">Costo totale</span>
                                        <strong class="text-sum"><b><?php echo $somma_prezzi_formattata; ?>€</b></strong>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-6 col-lg-7">
                                <form action="manage_pagamento.php" method="post" class="needs-validation" onsubmit="return confermaPagamento()" novalidate>
                                    <input type="hidden" name="differenza" value="<?php echo number_format(($credito_utente - $somma_prezzi_formattata), 2); ?>">
                                    <h4 class="mb-3 text-payment">Modulo di pagamento</h4>
                                    <div class="row gy-3">
                                        <div class="col-md-6">
                                            <label for="nome" class="form-label text-payment-field">Nome sulla carta</label>
                                            <input type="text" class="form-control border border-white" name="nome" placeholder="es. MARIO ROSSI" onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Z]+\s[A-Z]+" title="Inserisci due serie di lettere separate da uno spazio" required />
                                            <small class="text-body-secondary text-small">Nome e cognome presenti sulla carta</small>
                                            <div class="invalid-feedback">Campo richiesto !</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="numero" class="form-label text-payment-field">Numero di carta</label>
                                            <input type="text" class="form-control border border-white" name="numero" placeholder="es. 1111 2222 3333 4444" maxlength="19" pattern="[0-9]{4}\s[0-9]{4}\s[0-9]{4}\s[0-9]{4}" required />
                                            <div class="invalid-feedback">Campo richiesto !</div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="scadenza" class="form-label text-payment-field">Scadenza</label>
                                            <input type="text" class="form-control border border-white" name="scadenza" placeholder="es. 02/27" id="scadenza" title="Inserire una data compresa tra <?php echo date('m') . '/' . date('y') . ' e 12/30'; ?>" required />
                                            <div class="invalid-feedback">Campo richiesto !</div>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="CVV" class="form-label text-payment-field">CVV</label>
                                            <input type="text" class="form-control border border-white" name="CVV" placeholder="es. 123" maxlength="3" pattern="[0-9]{3}" required />
                                            <div class="invalid-feedback">Campo richiesto !</div>
                                        </div>

                                    </div>
                                    <div class="mt-3 d-flex justify-content-center">
                                        <button class="w-50 btn btn-primary btn-lg text-button" type="submit">
                                            Conferma pagamento
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div class="spacer2"></div>

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
        <script src="../../js/checkout.js"></script>

        <script src="../../js/main.js"></script>
        <script>
            function printInvalidVisualizzazione() {
                alert("Non puoi procedere al pagamento, non hai selezionato articoli!");
                window.location.href = "../selezione_catalogo/catalogo.php"; //reindirizzamento al catalogo articoli per una possibile selezione
            }
            function printInvalidPagamento() {
                alert("Non puoi procedere al pagamento, non hai sufficiente credito!");
                window.location.href = "../selezione_catalogo/carrello.php"; //reindirizzamento al carrello utente per una possibile rimozione 
                <?php
                $pagamento = 2;
                ?>
            }
            function printInvalidCredito(){
                alert("I tuoi acquisti sul sito sono terminati, hai 0€!");
                window.location.href = "../selezione_catalogo/carrello.php"; //reindirizzamento al carrello utente per una possibile rimozione (0€)
                <?php
                $pagamento = 2;
                ?>
            }
            function printInvalidNome() {
                alert("Attenzione, il nome inserito non corrisponde a quello attualmente registrato!"); //avviso dell'errore sul nome
                <?php
                $_SESSION["invalid_nome"] = false;
                ?>
            }
            function confermaPagamento() {
                // mostra un alert di conferma
                if (confirm("Vuoi davvero confermare il pagamento?")) {
                    return true; // consente l'invio del modulo se l'utente conferma
                } else {
                    return false; // impedisce l'invio del modulo se l'utente annulla
                }
            }
            document.addEventListener('DOMContentLoaded', function() {
                const scadenzaInput = document.getElementById("scadenza");

                scadenzaInput.addEventListener("input", function() {
                    let value = scadenzaInput.value;

                    // Rimuovo i caratteri non numerici
                    value = value.replace(/[^0-9]/g, '');

                    // Aggiungo lo "/" dopo il secondo carattere
                    if (value.length >= 3) {
                        value = value.slice(0, 2) + "/" + value.slice(2, 4);
                    }
                    scadenzaInput.value = value;
                });

                scadenzaInput.addEventListener("blur", function() {
                    let value = scadenzaInput.value;

                    // Mi assicuro che l'input sia nel formato MM/AA
                    if (value.length === 5 && value[2] === "/") {
                        const month = parseInt(value.slice(0, 2), 10);
                        const year = parseInt(value.slice(3, 5), 10);
                        const dataCorrente = new Date();
                        var numeroMeseCorrente = dataCorrente.getMonth(); // numero del mese corrente (basato su zero)
                        var annoCorrente = dataCorrente.getFullYear() % 100; // anno corrente
                        numeroMeseCorrente += 1; // aggiungo 1 al numero del mese per ottenere il numero in formato normale (da 1 a 12)
                        
                        if(numeroMeseCorrente < 10){
                            var numeroMeseStampa = "0" + numeroMeseCorrente;    
                        }
                        else{
                            var numeroMeseStampa = numeroMeseCorrente;
                        }

                        //validazione formato della data
                        if (year >= 24 && year <= 30) {
                            if(year == 24){
                                if(month >= numeroMeseCorrente && month <= 12){
                                    return;
                                }
                            }
                            else{
                                if(month >= 1 && month <= 12){
                                    return;
                                }
                            }
                        }
                    }
                    alert("Inserisci una data nel formato MM/YY da " + numeroMeseStampa + "/" + annoCorrente + " a 12/30"); //alert per formato invalido
                    scadenzaInput.value = "";
                });
            });
        </script>
    </body>

</html>