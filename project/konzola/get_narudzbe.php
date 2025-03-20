<?php

$host = 'localhost'; 
$dbname = 'korisnici';
$username = 'root'; 
$password = ''; 

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Povezivanje na bazu nije uspjelo: ' . $conn->connect_error]);
    exit;
}



$sql = "SELECT n.id, k.username, n.datum, n.status, n.metoda_dostave, n.adresa, n.telefon, n.ukupna_cijena
        FROM narudzbe n
        JOIN korisnici k ON n.korisnik_id = k.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$narudzbe = [];
while ($row = $result->fetch_assoc()) {
    $narudzbe[] = $row;
}

echo json_encode(['status' => 'success', 'narudzbe' => $narudzbe]);
?>
