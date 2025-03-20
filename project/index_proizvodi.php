<?php

$host = 'localhost';
$dbname = 'korisnici';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Povezivanje na bazu nije uspjelo: " . $conn->connect_error);
}

// SQL upiti za dohvat po jednog proizvoda od svakog proizvodaca
$proizvodaci = ['Logitech', 'Corsair', 'Razer'];
$proizvodi = [];

foreach ($proizvodaci as $proizvodac) {
    $query = "SELECT * FROM proizvodi WHERE proizvodac = '$proizvodac' LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $proizvodi[] = $row; 
    }
}

if (count($proizvodi) > 0) {
    echo json_encode(['status' => 'success', 'data' => $proizvodi]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Nema proizvoda.']);
}

$conn->close();
?>
