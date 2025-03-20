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
    $product_id = $_POST['product_id'];
    $naziv = $_POST['naziv'];
    $opis = $_POST['opis'];
    $cijena = $_POST['cijena'];
   
    $slika_url = $_POST['slika_url'];

    // Azuriraj podatke proizvoda u bazi
    $sql = "UPDATE proizvodi SET naziv = ?, opis = ?, cijena = ?, slika = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $naziv, $opis, $cijena, $slika_url, $product_id);

    if ($stmt->execute()) {
        header("Location: /project/konzola/konzola.html");
    } else {
        echo "Error";
    }

    $stmt->close();
}

$conn->close();
?>
