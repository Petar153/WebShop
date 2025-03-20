<?php

$host = 'localhost';
$dbname = 'korisnici'; 
$username = 'root'; 
$password = ''; 

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Povezivanje na bazu nije uspjelo: " . $conn->connect_error);
}

// Provjera postoji li parametar za filtriranje po proizvodacu
$proizvodac = isset($_GET['proizvodac']) ? $_GET['proizvodac'] : '';


$sql = "SELECT * FROM proizvodi";
if ($proizvodac) {
    $sql .= " WHERE proizvodac = ?";
}

$stmt = $conn->prepare($sql);

if ($proizvodac) {
    $stmt->bind_param("s", $proizvodac); 
}

$stmt->execute();
$result = $stmt->get_result();

// Provjeri ima li rezultata
if ($result->num_rows > 0) {
    $proizvodi = [];
    while ($row = $result->fetch_assoc()) {
        $proizvodi[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $proizvodi]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Nema proizvoda']);
}

$conn->close();
?>
