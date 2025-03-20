<?php
session_start();
header('Content-Type: application/json');

if ($_SESSION['uloga'] === 'admin') {
    $conn = new mysqli('localhost', 'root', '', 'korisnici');
    $sql = "SELECT id, ime, prezime, username, email, uloga FROM korisnici";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode(['status' => 'success', 'users' => $users]);

    $conn->close();
} 
?>


