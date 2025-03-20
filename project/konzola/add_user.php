<?php
session_start();
if ($_SESSION['uloga'] !== 'admin') {
    echo "Nemate ovlasti. <a href='/project/index.html'>Vrati se na pocetnu</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = $_POST['username'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $lozinka = $_POST['lozinka'];
    $uloga = $_POST['uloga'];

    
    $conn = new mysqli('localhost', 'root', '', 'korisnici');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL upit za unos korisnika
    $sql = "INSERT INTO korisnici (username, ime, prezime, email, lozinka, uloga) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssss', $username, $ime, $prezime, $email, $lozinka, $uloga);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Korisnik je uspješno dodan!']);
        header("Location: /project/konzola/konzola.html");
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Greška pri dodavanju korisnika: ' . $conn->error]);
    }
    

    $conn->close();
}
?>
