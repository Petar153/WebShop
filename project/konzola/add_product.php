<?php
session_start();
if ($_SESSION['uloga'] !== 'admin') {
    echo "Nemate ovlasti. <a href='/project/index.html'>Vrati se na pocetnu</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $naziv = $_POST['naziv'];
    $proizvodac = $_POST['proizvodac'];
    $cijena = $_POST['cijena'];
    $slika = $_POST['slika'];
    $opis = $_POST['opis'];

    
    $host = 'localhost';
    $dbname = 'korisnici';
    $username = 'root';
    $password = '';
    
    $conn = new mysqli($host, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Povezivanje na bazu nije uspjelo: ' . $conn->connect_error]);
        exit;
    }

    // SQL upit za unos proizvoda
    $sql = "INSERT INTO proizvodi (naziv, proizvodac, cijena, slika, opis) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $naziv, $proizvodac, $cijena, $slika, $opis);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Proizvod je uspješno dodan!']);
        header("Location: /project/konzola/konzola.html");
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Došlo je do greške prilikom dodavanja proizvoda.']);
    }


    $conn->close();
}
?>
