<?php
require_once("../../databases/database_progetto/Mysingleton1.php");
$connection = Mysingleton1::getInstance();
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["nome"])) {
    //gestione registrazione utente
    $CF = $_POST["codice_fiscale"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $telefono = $_POST["telefono"];
    $data_input = $_POST["data_nascita"];
    //conversione data di nascita
    $data_nascita = date("Y-m-d", strtotime($data_input));
    $email = $_POST["email"];
    $password = $_POST["password"];

    //controllo sulla lunghezza del codice fiscale
    if (strlen($CF) != 16) {
        $_SESSION["invalid_CF"] = true;
        header("Location: registrazione.php");
        exit;
    }
    else{
        //controllo sulla presenza del codice fiscale (non possono esserci due codici fiscali uguali nel db)
        $query_CF = "SELECT CF
                     FROM Utente";
        $sth_check_CF = $connection->prepare($query_CF);
        $sth_check_CF->execute();
        while($row_CF = $sth_check_CF->fetch(PDO::FETCH_OBJ)){
            if($row_CF->CF == $CF){
                $_SESSION["invalid_CF"] = true;
                break;
            }
        }
        if($_SESSION["invalid_CF"] == true){
            header("Location: registrazione.php");
            exit;
        }
    }

    //controllo sulla presenza della mail (non possono esserci due email uguali nel db)
    $query_email = "SELECT email
                    FROM Utente";
    $sth_check_email = $connection->prepare($query_email);
    $sth_check_email->execute();
    while($row_email = $sth_check_email->fetch(PDO::FETCH_OBJ)){
        if($row_email->email == $email){
            $_SESSION["invalid_email"] = true;
            break;
        }
    }
    if($_SESSION["invalid_email"] == true){
        header("Location: registrazione.php");
        exit;
    }

    //dati di registrazione corretti
    if($_SESSION["invalid_CF"] == false && $_SESSION["invalid_email"] == false) {
        //criptazione della password
        $salt = bin2hex(random_bytes(16));
        $iterations = random_int(10_000, 50_000);
        $password_hash = hash_pbkdf2("sha512", $password, $salt, $iterations);

        $query_password = ' INSERT
                            INTO password_utente(password_hash, salt, iterations)
                            VALUES (:password_hash, :salt, :iterations)';
        $sth_password = $connection->prepare($query_password);
        $sth_password->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);
        $sth_password->bindParam(":salt", $salt, PDO::PARAM_STR);
        $sth_password->bindParam(":iterations", $iterations, PDO::PARAM_INT);
        $sth_password->execute();
        $last_index = $connection->lastInsertId();

        $query_utente = '   INSERT 
                            INTO Utente(CF, nome, cognome, telefono, data_nascita, email, Id_password)
                            VALUES(:codice_fiscale, :nome, :cognome, :telefono, :data_nascita, :email, :id_password)';
        $sth_utente = $connection->prepare($query_utente);
        $sth_utente->bindParam(":codice_fiscale", $CF, PDO::PARAM_STR);
        $sth_utente->bindParam(":nome", $nome, PDO::PARAM_STR);
        $sth_utente->bindParam(":cognome", $cognome, PDO::PARAM_STR);
        $sth_utente->bindParam(":telefono", $telefono, PDO::PARAM_STR);
        $sth_utente->bindParam(":data_nascita", $data_nascita, PDO::PARAM_STR);
        $sth_utente->bindParam(":email", $email, PDO::PARAM_STR);
        $sth_utente->bindParam(":id_password", $last_index, PDO::PARAM_STR);
        $sth_utente->execute();
        header("Location: login.php");
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["email_login"])) {
    //gestione login utente
    $email = $_POST["email_login"];
    $password_login  = $_POST["password_login"];

    $query_email = 'SELECT Id_utente, Id_password
                    FROM Utente
                    WHERE email = :email';
    $sth_email = $connection->prepare($query_email);
    $sth_email->bindParam(":email", $email, PDO::PARAM_STR);
    $sth_email->execute();
    $row_utente = $sth_email->fetch(PDO::FETCH_OBJ);
    if ($sth_email->rowCount() == 0) {
        $_SESSION["invalid_account"] = -1; //account inesistente
        header("Location: login.php");
        exit;
    } else {
        $id_password = $row_utente->Id_password;
        $query_parameters = "SELECT *
                             FROM password_utente
                             WHERE Id_password = :id_password";
        $sth_parameters = $connection->prepare($query_parameters);
        $sth_parameters->bindParam(":id_password", $id_password, PDO::PARAM_INT);
        $sth_parameters->execute();
        $row_password = $sth_parameters->fetch(PDO::FETCH_OBJ);

        $hash = $row_password->password_hash;
        $salt = $row_password->salt;
        $iterations = $row_password->iterations;
        $password_calculated = hash_pbkdf2("sha512", $password_login, $salt, $iterations);

        if ($password_calculated == $hash) {
            $_SESSION["invalid_account"] = 1; //account esistente
            $_SESSION["utente"] = $row_utente->Id_utente; //valorizzazione della sessione utente
            $_SESSION["visualizza_catalogo"] = true;
            header("Location: ../dati_utente/utente.php?u=" . $_SESSION["utente"]);
            exit;
        } else {
            $_SESSION["invalid_account"] = -1; //account inesistente
            header("Location: login.php");
            exit;
        }
    }
}