<?php
try {
    $konekcija = new mysqli("localhost", "root", "", "zlatara_db");

    if ($konekcija->connect_error) {
        throw new Exception("Greška pri konekciji na bazu.");
    }

} catch(Exception $e){
    echo "Došlo je do greške: " . $e->getMessage();
}
?>