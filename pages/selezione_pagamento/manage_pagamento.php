<?php
session_start();
require_once("../../databases/database_progetto/Mysingleton1.php");
$connection = Mysingleton1::getInstance();
$Id_utente = $_SESSION["utente"];
$nome_cookie = "carrello_articoli_per_" . $Id_utente;

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["nome"])){
    //pagamento teoricamente valido, dipende dal nome carta
    $nuovo_credito = $_POST["differenza"];
    $nome_carta = $_POST["nome"];
    $numero_carta = $_POST["numero"];
    $scadenza = $_POST["scadenza"];
    $CVV = $_POST["CVV"];

    $array_nome = explode(" ", $nome_carta);
    $nome = $array_nome[0];
    $cognome = $array_nome[1];
    //query per controllare se il nome e il cognome inseriti corrispondono a quelli presenti nel db
    $query_anagrafica = "SELECT nome, cognome
                         FROM Utente
                         WHERE Id_utente = :id_utente";
    $sth_anagrafica = $connection->prepare($query_anagrafica);
    $sth_anagrafica->bindParam(":id_utente", $Id_utente, PDO::PARAM_INT);
    $sth_anagrafica->execute();
    $row_anagrafica = $sth_anagrafica->fetch(PDO::FETCH_OBJ);
    if(strtoupper($row_anagrafica->nome) == $nome && strtoupper($row_anagrafica->cognome) == $cognome){
        //nome e cognome corrispondono, quindi aggiorno il credito dell'utente ed inizializzo il cookie
        if( $nuovo_credito <= 0){
            $nuovo_credito = number_format(0,2);
        }
        setcookie($nome_cookie, "vuoto", time() + (86400 * 30), "/");
        $update_credito = " UPDATE Utente
                            SET credito = :differenza
                            WHERE Id_utente = :id_utente";
        $sth_update_credito = $connection->prepare($update_credito);
        $sth_update_credito->bindParam(":differenza", $nuovo_credito);
        $sth_update_credito->bindParam(":id_utente", $Id_utente, PDO::PARAM_INT);
        $sth_update_credito->execute();
        if($nuovo_credito <= 0){
            $_SESSION["advise_credito"] = true; //valorizzazione variabile di sessione per visualizzare l'avviso di 0€
            header("Location: ../selezione_catalogo/catalogo.php", true, 301);
            exit;
        }
        else{
            $_SESSION["advise_pagamento"] = true; //valorizzazione variabile di sessione per visualizzare l'avviso di pagamento avvenuto
            header("Location: ../selezione_catalogo/catalogo.php", true, 301);
            exit;
        }
    }
    else{
        //nome e cognome non corrispondono, quindi valorizzo la variabile di sessione per visualizzare l'errore sul nome carta
        $_SESSION["invalid_nome"] = true;
        header("Location: pagamento.php", true, 301);
        exit;
    }   
}