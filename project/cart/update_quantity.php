<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Korisnik nije prijavljen']);
    exit;
}

$user_id = $_SESSION['user_id'];
$proizvod_id = $_POST['proizvod_id'];
$akcija = $_POST['akcija']; // 'increase' ili 'decrease'

$host = 'localhost';
$dbname = 'korisnici';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Povezivanje na bazu nije uspjelo: ' . $conn->connect_error]);
    exit;
}

// Dohvati trenutnu kolicinu proizvoda u kosarici
$sql = "SELECT kolicina FROM kosarica WHERE user_id = ? AND proizvod_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $user_id, $proizvod_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $trenutna_kolicina = $row['kolicina'];

    // Provjeri akciju (povecaj ili smanji)
    if ($akcija === 'increase') {
        $nova_kolicina = $trenutna_kolicina + 1;
    } elseif ($akcija === 'decrease' && $trenutna_kolicina > 1) {
        $nova_kolicina = $trenutna_kolicina - 1;
    } else {
        // Ako je smanjenje, ali kolicina je 1, ne dopustamo smanjenje ispod 1
        echo json_encode(['status' => 'error', 'message' => 'Kolicina ne moze biti manja od 1']);
        exit;
    }

    // Azuriraj kolicinu u kosarici
    $sql = "UPDATE kosarica SET kolicina = ? WHERE user_id = ? AND proizvod_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $nova_kolicina, $user_id, $proizvod_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Kolicina azurirana']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Greska pri azuriranju kolicine']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Proizvod nije u kosarici']);
}

$conn->close();
?>
