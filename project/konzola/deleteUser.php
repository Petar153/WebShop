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


$userId = $_POST['userId'];

$sql = "DELETE FROM korisnici WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Greska pri brisanju korisnika.']);
}

$conn->close();
?>
