<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Korisnik nije prijavljen']);
    exit;
}

$user_id = $_SESSION['user_id'];

$host = 'localhost';
$dbname = 'korisnici';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Povezivanje na bazu nije uspjelo: ' . $conn->connect_error]);
    exit;
}

// Dohvati proizvode u kosarici
$sql = "SELECT p.id, p.naziv, p.cijena, k.kolicina FROM kosarica k
        JOIN proizvodi p ON k.proizvod_id = p.id
        WHERE k.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$kosarica = [];

while ($row = $result->fetch_assoc()) {
    $kosarica[] = $row;
}

echo json_encode(['status' => 'success', 'kosarica' => $kosarica]);

$conn->close();
?>
