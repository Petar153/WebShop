<?php

// ovo je forma
session_start();

$host = 'localhost';
$dbname = 'korisnici';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Povezivanje na bazu nije uspjelo: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("ID korisnika nije naveden.");
}

$user_id = $_GET['id'];

$sql = "SELECT * FROM korisnici WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Korisnik nije pronaden.");
}

$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uredi korisnika</title>
</head>
<body>
    <h2>Uredi korisnika</h2>
    <form action="/project/konzola/edit_user.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

        <label for="username">Korisnicko ime:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br><br>
        
        <label for="ime">Ime:</label>
        <input type="text" id="ime" name="ime" value="<?php echo $user['ime']; ?>" required><br><br>
        
        <label for="prezime">Prezime:</label>
        <input type="text" id="prezime" name="prezime" value="<?php echo $user['prezime']; ?>" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>
        
        <label for="lozinka">Lozinka:</label>
        <input type="password" id="lozinka" name="lozinka"><br><br> <!-- Lozinka ostaje prazna ako se ne mijenja -->
        
        <label for="uloga">Uloga:</label>
        <select id="uloga" name="uloga" required>
            <option value="admin" <?php if ($user['uloga'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="mod" <?php if ($user['uloga'] == 'mod') echo 'selected'; ?>>Mod</option>
            <option value="user" <?php if ($user['uloga'] == 'user') echo 'selected'; ?>>User</option>
        </select><br><br>
        
        <button type="submit">Spremi promjene</button>
        <a href="/project/konzola/konzola.html">Vrati se</a>
    </form>
</body>
</html>

<?php
$conn->close();
?>
