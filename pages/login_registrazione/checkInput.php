<?php
require_once("../../databases/database_trasferte/Mysingleton1.php");
$connection = Mysingleton1::getInstance();
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["nome"])) {
    $CF = $_POST["codice_fiscale"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $nazionalita = $_POST["nazionalita"];
    $data_nascita = $_POST["data_nascita"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    //for checking CF length
    if (strlen($CF) != 16) {
        $_SESSION["invalid_CF"] = false;
        header("Location: registrazione.php");
        exit;
    }
    
    //for checking date
    /*list($year, $month, $day) = explode('-', $data_nascita);
    if (!checkdate($month, $day, $year)) {
        $_SESSION["invalid_data"] = false;
        header("Location: registrazione.php");
        exit;
    }*/

    //for crypting password
    $salt = bin2hex(random_bytes(16));
    $iterations = random_int(100_000, 1_000_000);
    $password_hash = hash_pbkdf2("sha512", $password, $salt, $iterations);

    $query_password = ' INSERT
                        INTO password_utente(password_hash, salt, iterations)
                        VALUES (:password_hash, :salt, :iterations)';
    $sth_password = $connection->prepare($query_password);
    $sth_password->bindParam(":password_hash", $password_hash);
    $sth_password->bindParam(":salt", $salt);
    $sth_password->bindParam(":iterations", $iterations);
    $sth_password->execute();
    $last_index = $connection->lastInsertId();

    $query_utente = '   INSERT 
                        INTO utente(CF, nome, cognome, nazionalita, data_nascita, email, Id_password)
                        VALUES(:codice_fiscale, :nome, :cognome, :nazionalita, :data_nascita, :email, :id_password)';
    $sth_utente = $connection->prepare($query_utente);
    $sth_utente->bindParam(":codice_fiscale", $CF);
    $sth_utente->bindParam(":nome", $nome);
    $sth_utente->bindParam(":cognome", $cognome);
    $sth_utente->bindParam(":nazionalita", $nazionalita);
    $sth_utente->bindParam(":data_nascita", $data_nascita);
    $sth_utente->bindParam(":email", $email);
    $sth_utente->bindParam(":id_password", $last_index);
    $sth_utente->execute();
}
