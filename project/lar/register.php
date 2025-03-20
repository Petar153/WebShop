<?php
session_start();
include 'spoj.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $lozinka = $_POST['lozinka'];


    
    // Provjera postoji li korisnicko ime ili email
    $provjera = $conn->query("SELECT * FROM korisnici WHERE username='$username' OR email='$email'");
    if ($provjera->num_rows > 0) {
        echo "Korisnicko ime ili email vec postoji.";
    } else {
        // Dodavanje novog korisnika s ulogom 'kupac'
        $uloga = 'kupac';
        $stmt = $conn->prepare("INSERT INTO korisnici (ime, prezime, email, username, lozinka, uloga) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $ime, $prezime, $email, $username, $lozinka, $uloga);

        if ($stmt->execute()) {
            // Automatska prijava nakon uspjesne registracije
            $_SESSION['prijavljen'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['ime'] = $ime;
            $_SESSION['prezime'] = $prezime;
            $_SESSION['uloga'] = $uloga;

            // Preusmjeravanje
            header("Location: /project/index.html");
        } else {
            echo "Doslo je do pogreske prilikom registracije.";
        }
    }
}
$conn->close();
?>
