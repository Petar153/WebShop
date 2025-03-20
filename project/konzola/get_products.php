<?php
session_start();
header('Content-Type: application/json');

if ($_SESSION['uloga'] === 'admin' || $_SESSION['uloga'] === 'mod') {
    $conn = new mysqli('localhost', 'root', '', 'korisnici');
    $sql = "SELECT id, naziv, proizvodac, cijena, opis FROM proizvodi";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode(['status' => 'success', 'products' => $products]);

    $conn->close();
}
?>
