<?php
session_start();
include 'spoj.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $lozinka = $_POST['lozinka'];


    $stmt = $conn->prepare("SELECT * FROM korisnici WHERE username = ? AND lozinka = ?");
    $stmt->bind_param("ss", $username, $lozinka);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        

        $row = $result->fetch_assoc();
        $_SESSION['prijavljen'] = true;
        $_SESSION['user_id'] = $row['id']; 
        $_SESSION['username'] = $row['username'];
        $_SESSION['ime'] = $row['ime'];
        $_SESSION['prezime'] = $row['prezime'];
        $_SESSION['uloga'] = $row['uloga'];
       
        header("Location: /project/index.html");
     
    } else {
        echo "Korisnik ne postoji.";
    }
}
$conn->close();
?>
