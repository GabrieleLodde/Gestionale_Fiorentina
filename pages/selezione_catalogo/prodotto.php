<?php
session_start();
if(isset($_GET["p"])){
    echo "fai roba";
}
else{
    $_SESSION["invalid_prodotto"] = true; //aggiorno valore della variabile di sessione per visualizzare l'alert nella pagina catalogo
    header("Location: catalogo.php");
    exit();
}