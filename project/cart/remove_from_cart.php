<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Korisnik nije prijavljen']);
    exit;
}

$user_id = $_SESSION['user_id'];
$proizvod_id = $_POST['proizvod_id'];

$host = 'localhost';
$dbname = 'korisnici';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Povezivanje na bazu nije uspjelo: ' . $conn->connect_error]);
    exit;
}

// Brisanje proizvoda iz kosarice
$sql = "DELETE FROM kosarica WHERE user_id = ? AND proizvod_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $user_id, $proizvod_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Proizvod uklonjen iz kosarice']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Greska pri uklanjanju proizvoda']);
}

$conn->close();
?>
