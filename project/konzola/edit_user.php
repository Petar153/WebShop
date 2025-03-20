<?php

//ovo je obrada forme
session_start();

$host = 'localhost';
$dbname = 'korisnici';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Povezivanje na bazu nije uspjelo: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $uloga = $_POST['uloga'];

    // Ako ima lozinke promjeni, inace ostavi staru
    if (!empty($_POST['lozinka'])) {
        $lozinka = $_POST['lozinka'];
        $sql = "UPDATE korisnici SET username = ?, ime = ?, prezime = ?, email = ?, lozinka = ?, uloga = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $username, $ime, $prezime, $email, $lozinka, $uloga, $user_id);
    } else {
        $sql = "UPDATE korisnici SET username = ?, ime = ?, prezime = ?, email = ?, uloga = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $username, $ime, $prezime, $email, $uloga, $user_id);
    }

    if ($stmt->execute()) {
        header("Location: /project/konzola/konzola.html");
    } else {
        echo "Error";
    }

    $stmt->close();
}

$conn->close();
?>
