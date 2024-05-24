<?php
// modifica dati utente
//eliminare account (eliminazione account)
session_start();
if (!isset($_SESSION["modifica_account"]) || !isset($_SESSION["invalid_CF"]) || !isset($_SESSION["invalid_email"])) {
  $_SESSION["modifica_account"] = 0;
  $_SESSION["invalid_CF"] = false;
  $_SESSION["invalid_email"] = false;
}
if ($_SESSION["invalid_account"] == 1) {
  require_once("../../databases/database_progetto/Mysingleton1.php");
  $connection = Mysingleton1::getInstance();
  $Id_utente = $_GET["u"];
  $query_utente = " SELECT CF, nome, cognome, telefono, data_nascita, email
                    FROM Utente
                    WHERE Id_utente = :id_utente";
  $sth_utente = $connection->prepare($query_utente);
  $sth_utente->bindParam(":id_utente", $Id_utente, PDO::PARAM_INT);
  $sth_utente->execute();
  $row_utente = $sth_utente->fetch(PDO::FETCH_OBJ);
  $CF = $row_utente->CF;
  $nome = $row_utente->nome;
  $cognome = $row_utente->cognome;
  $telefono = $row_utente->telefono;
  $data_db = $row_utente->data_nascita;
  $timestamp_data = strtotime($data_db);
  $formato = 'd/m/Y';
  $data_nascita = date($formato, $timestamp_data);
  $email = $row_utente->email;

  //var_dump($_SESSION["invalid_account"]);
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

  <body <?php
        if ($_SESSION["invalid_CF"] == true) {
        ?> onload="printInvalidCF()" <?php
                                    } else if ($_SESSION["invalid_email"] == true) {
                                      ?> onload="printInvalidEmail()" <?php
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
                  <li><a href="../selezione_catalogo/catalogo.php" class="nav-link">Catalogo</a></li>
                  <li><a href="../serie_a/classifica.php" class="nav-link">Classifica Serie A 2023/2024</a></li>
                  <li><a href="../serie_a/highlights.php" class="nav-link">Highlights Serie A 2023/2024</a></li>
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
              <?php if ($_SESSION["modifica_account"] == 0) { ?>
                <form>
                  <div class="form-group">
                    <input type="text" name="codice_fiscale" maxlength="16" placeholder="Codice fiscale: <?php echo "$CF"; ?>" class="form-control" disabled>
                  </div>
                  <div class="form-group">
                    <input type="text" name="nome" placeholder="Nome: <?php echo "$nome"; ?>" class="form-control" disabled>
                  </div>
                  <div class="form-group">
                    <input type="text" name="cognome" placeholder="Cognome: <?php echo "$cognome"; ?>" class="form-control" disabled>
                  </div>
                  <div class="form-group">
                    <input type="text" name="telefono" placeholder="Numero di telefono: <?php echo "$telefono"; ?>" class="form-control" disabled>
                  </div>
                  <div class="form-group">
                    <input type="text" name="data_nascita" placeholder="Data di nascita: <?php echo "$data_nascita"; ?>" class="form-control" disabled>
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" placeholder="Email: <?php echo "$email"; ?>" class="form-control" disabled>
                  </div>
                  <div class="form-group text-center">
                    <a href="manage_utente.php?u=<?php echo $Id_utente; ?>&r=mod" class="btn btn-primary py-3 px-5">Modifica dati</a>
                    <a href="#" onclick="confermaEliminazione('<?php echo $Id_utente; ?>')" class="btn btn-primary py-3 px-5">Elimina account</a>
                    <a href="#" onclick="confermaUscita('<?php echo $Id_utente; ?>')" class="btn btn-primary py-3 px-5">Esci</a>
                  </div>
                </form>
              <?php  } else if ($_SESSION["modifica_account"] == 1) {
                $data_corrente = date("Y-m-j");
              ?>
                <form action="manage_utente.php?u=<?php echo $Id_utente; ?>&r=save" method="post" onsubmit="return confermaInvio()">
                  <div class="form-group">
                    <input type="text" name="codice_fiscale" maxlength="16" value="<?php echo $CF; ?>" onkeyup="this.value = this.value.toUpperCase();" pattern="[A-Z]{6}[0-9]{2}[A-Z]{1}[0-9]{2}[A-Z]{1}[0-9]{3}[A-Z]{1}" class="form-control" data-toggle="tooltip" data-placement="top" data-html="true" title="<b>esempio</b> RSSMRA85M01H501Z">
                  </div>
                  <div class="form-group">
                    <input type="text" name="nome" value="<?php echo $nome; ?>" class="form-control">
                  </div>
                  <div class="form-group">
                    <input type="text" name="cognome" value="<?php echo $cognome; ?>" class="form-control">
                  </div>
                  <div class="form-group">
                    <input type="tel" name="telefono" maxlength="14" value="<?php echo $telefono; ?>" class="form-control" pattern="\+[0-9]{2}\s[0-9]{10}" data-toggle="tooltip" data-placement="top" data-html="true" title="<b>esempio</b> +39 4445556666">
                  </div>
                  <div class="form-group">
                    <input type="text" onfocus="(this.type='date')" name="data_nascita" min="1900-01-01" max="<?php echo $data_corrente; ?>" value="<?php echo $data_nascita; ?>" class="form-control" data-toggle="tooltip" data-placement="top" data-html="true" title="<b>data minima</b> 01/01/1900 <b>data massima</b> odierna">
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" value="<?php echo $email; ?>" class="form-control">
                  </div>
                  <div class="form-group text-center">
                    <input type="submit" value="Salva modifiche" class="btn btn-primary py-3 px-4">
                    <a href="#" onclick="confermaMantieni('<?php echo $Id_utente; ?>')" class="btn btn-primary py-3 px-4">Mantieni dati</a>
                  </div>
                </form>
              <?php }  ?>
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
      $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>
    <script>
      function confermaEliminazione(idUtente) {
        // Mostra un alert di conferma
        if (confirm("Vuoi davvero eliminare definitivamente questo account?")) {
          // Se l'utente conferma, reindirizza alla pagina di gestione dell'utente con il parametro "r=del"
          window.location.href = 'manage_utente.php?u=' + idUtente + '&r=del';
        }
      }

      function confermaInvio() {
        // Mostra un alert di conferma
        if (confirm("Vuoi davvero salvare le modifiche?")) {
          return true; // Consente l'invio del modulo se l'utente conferma
        } else {
          return false; // Impedisce l'invio del modulo se l'utente annulla
        }
      }

      function confermaUscita(idUtente) {
        // Mostra un alert di conferma
        if (confirm("Vuoi davvero uscire?")) {
          // Se l'utente conferma, reindirizza alla pagina di gestione dell'utente con il parametro "r=esc"
          window.location.href = 'manage_utente.php?u=' + idUtente + '&r=esc';
        }
      }

      function confermaMantieni(idUtente) {
        // Mostra un alert di conferma
        if (confirm("Sei sicuro di voler mantenere i dati originari?")) {
          // Se l'utente conferma, reindirizza alla pagina di gestione dell'utente con il parametro "r=esc"
          window.location.href = 'manage_utente.php?u=' + idUtente + '&r=mod_esc';
        }
      }

      function printInvalidCF() {
        alert("Attenzione, il codice fiscale non è valido!");
        <?php
        $_SESSION["invalid_CF"] = false;
        ?>
      }

      function printInvalidEmail() {
        alert("Attenzione, l'email non è valida!");
        <?php
        $_SESSION["invalid_email"] = false;
        ?>
      }
    </script>
  </body>

  </html>
<?php
} else {
  $_SESSION["invalid_request"] = -1; //richiesta della pagina senza essere in una sessione specifica
  header("Location: ../../index.php");
}