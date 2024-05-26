<?php
session_start();
require_once("../../databases/database_progetto/Mysingleton1.php");
$connection = Mysingleton1::getInstance();

$id_articoli = $_SESSION["articoli"];
$query_prezzi = "";
foreach ($id_articoli as $id) {
    $query_prezzi .= "  SELECT ROUND((A.prezzo_base -(A.prezzo_base/100 * S.valore)), 2) as prezzo_scontato
                        FROM Articolo A 
                        INNER JOIN Sconto S ON A.Id_sconto = S.Id_sconto
                        WHERE A.Id_articolo = $id
                        UNION ALL ";
    }

    // Rimuovi l'ultima "UNION ALL" dalla query
$query_prezzi = rtrim($query_prezzi, "UNION ALL ");
$sth_prezzi = $connection->prepare($query_prezzi);
$sth_prezzi->execute();
$somma_prezzi = 0;
while($row_prezzi = $sth_prezzi->fetch(PDO::FETCH_OBJ)){
    $somma_prezzi+=$row_prezzi->prezzo_scontato;
}
echo $somma_prezzi;