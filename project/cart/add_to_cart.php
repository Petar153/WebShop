<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Korisnik nije prijavljen']);
    exit;
}

$user_id = $_SESSION['user_id'];
$proizvod_id = $_POST['proizvod_id'];
$kolicina = $_POST['kolicina'] ?? 1;  // Ako nije navedena kolicina, koristi 1

$host = 'localhost';
$dbname = 'korisnici';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Povezivanje na bazu nije uspjelo: ' . $conn->connect_error]);
    exit;
}

// Provjera postoji li proizvod vec u kosarici
$sql = "SELECT * FROM kosarica WHERE user_id = ? AND proizvod_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $user_id, $proizvod_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Ako proizvod postoji, povecaj kolicinu
    $sql = "UPDATE kosarica SET kolicina = kolicina + ? WHERE user_id = ? AND proizvod_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $kolicina, $user_id, $proizvod_id);
} else {
    // Ako proizvod ne postoji, dodaj ga u kosaricu
    $sql = "INSERT INTO kosarica (user_id, proizvod_id, kolicina) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $user_id, $proizvod_id, $kolicina);
}

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Proizvod dodan u kosaricu']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Greska pri dodavanju proizvoda']);
}

$conn->close();
?>
