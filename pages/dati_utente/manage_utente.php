<?php
session_start();
require_once("../../databases/database_progetto/Mysingleton1.php");
$connection = Mysingleton1::getInstance();
$Id_utente = $Id_password = $_GET["u"]; //L'Id_utente sarà sempre uguale all'Id_password
if($_GET["r"] == "del"){
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
else if($_GET["r"] == "esc"){
    $_SESSION["invalid_account"] = 2; //cambio valore alla variabile di sessione per visualizzare l'alert di "disconnessione" in index.php
    header("Location: ../../index.php");
    exit;
}