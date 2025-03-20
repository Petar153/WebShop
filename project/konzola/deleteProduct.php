<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'korisnici';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Povezivanje na bazu nije uspjelo: ' . $conn->connect_error]));
}


$productId = $_POST['productId'];

$sql = "DELETE FROM proizvodi WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Greska pri brisanju proizvoda.']);
}

$conn->close();
?>
