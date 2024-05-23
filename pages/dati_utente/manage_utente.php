<?php
//r = request
//se r = del --> volontà di eliminare l'account
//se r = esc --> volontà di disconnettere l'account
//se r = mod --> volontà di modificare i dati dell'account
//se r = mod_esc --> volontà di mantenere di dati dell'account
//se r = save --> salvare i dati inseriti nella modifica
session_start();
require_once("../../databases/database_progetto/Mysingleton1.php");
$connection = Mysingleton1::getInstance();
$Id_utente = $Id_password = $_GET["u"]; //L'Id_utente sarà sempre uguale all'Id_password
//elimina account
if ($_GET["r"] == "del") {
    $_SESSION["invalid_account"] = 3; //cambio valore alla variabile di sessione per visualizzare l'alert di "rimozione" in index.php
    $query_delete_user = "DELETE 
                          FROM Utente
                          WHERE Id_utente = :id_utente";
    $sth_delete_user = $connection->prepare($query_delete_user);
    $sth_delete_user->bindParam(":id_utente", $Id_utente, PDO::PARAM_INT);
    $sth_delete_user->execute();

    $query_delete_password = "DELETE 
                              FROM Password_Utente
                              WHERE Id_password = :id_password";
    $sth_delete_password = $connection->prepare($query_delete_password);
    $sth_delete_password->bindParam(":id_password", $Id_password, PDO::PARAM_INT);
    $sth_delete_password->execute();
    header("Location: ../../index.php");
    exit;
}
//disconnetti account
else if ($_GET["r"] == "esc") {
    $_SESSION["invalid_account"] = 2; //cambio valore alla variabile di sessione per visualizzare l'alert di "disconnessione" in index.php
    header("Location: ../../index.php");
    exit;
}
//modifica dati
else if ($_GET["r"] == "mod") {
    $_SESSION["modifica_account"] = true;
    header("Location: utente.php?u=$Id_utente");
    exit;
}
//mantieni dati originari
else if ($_GET["r"] == "mod_esc") {
    $_SESSION["modifica_account"] = false;
    header("Location: utente.php?u=$Id_utente");
    exit;
}
//gestione modifica dati dell'account
else if ($_SERVER['REQUEST_METHOD'] == "POST" && $_GET["r"] == "save") {
    $CF = $_POST["codice_fiscale"];
    if (strlen($CF) != 16) {
        $_SESSION["invalid_CF"] = true;
        header("Location: utente.php?u=$Id_utente");
        exit;
    } else {
        //controllo sulla presenza del codice fiscale (non possono esserci due codici fiscali uguali nel db)
        $query_CF = "SELECT CF
                     FROM Utente
                     WHERE Id_utente <> :id_utente";
        $sth_check_CF = $connection->prepare($query_CF);
        $sth_check_CF->bindParam(":id_utente", $Id_utente, PDO::PARAM_INT);
        $sth_check_CF->execute();
        while ($row_CF = $sth_check_CF->fetch(PDO::FETCH_OBJ)) {
            if ($row_CF->CF == $CF) {
                $_SESSION["invalid_CF"] = true;
                break;
            }
        }
        if ($_SESSION["invalid_CF"] == true) {
            header("Location: utente.php?u=$Id_utente");
            exit;
        }
    }
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $numero_telefono = $_POST["telefono"];
    //conversione numero di telefono
    $telefono = "+" . substr($numero_telefono, 0, 2) . " " . substr($numero_telefono, 3, 3) . substr($numero_telefono, 7, 3) . substr($numero_telefono, 11, 4);
    $data_input = $_POST["data_nascita"];
    //conversione data di nascita
    $data_nascita = date("Y-m-d", strtotime($data_input));
    $email = $_POST["email"];
    //controllo sulla presenza della mail (non possono esserci due email uguali nel db)
    $query_email = "SELECT email
                    FROM Utente
                    WHERE Id_utente <> :id_utente";
    $sth_check_email = $connection->prepare($query_email);
    $sth_check_email->bindParam(":id_utente", $Id_utente, PDO::PARAM_INT);
    $sth_check_email->execute();
    while ($row_email = $sth_check_email->fetch(PDO::FETCH_OBJ)) {
        if ($row_email->email == $email) {
            $_SESSION["invalid_email"] = true;
            break;
        }
    }
    if ($_SESSION["invalid_email"] == true) {
        header("Location: utente.php?u=$Id_utente");
        exit;
    }
    if($_SESSION["invalid_CF"] == false && $_SESSION["invalid_email"] == false){
        $query_utente = '   UPDATE Utente 
                            SET CF = :codice_fiscale, nome = :nome, cognome = :cognome, telefono = :telefono, data_nascita = :data_nascita, email = :email
                            WHERE Id_utente = :id_utente';
        $sth_utente = $connection->prepare($query_utente);
        $sth_utente->bindParam(":codice_fiscale", $CF, PDO::PARAM_STR);
        $sth_utente->bindParam(":nome", $nome, PDO::PARAM_STR);
        $sth_utente->bindParam(":cognome", $cognome, PDO::PARAM_STR);
        $sth_utente->bindParam(":telefono", $telefono, PDO::PARAM_STR);
        $sth_utente->bindParam(":data_nascita", $data_nascita, PDO::PARAM_STR);
        $sth_utente->bindParam(":email", $email, PDO::PARAM_STR);
        $sth_utente->bindParam(":id_utente", $Id_utente, PDO::PARAM_INT);
        $sth_utente->execute();
        $_SESSION["modifica_account"] = false;
        header("Location: utente.php?u=$Id_utente");
        exit;
    }
}