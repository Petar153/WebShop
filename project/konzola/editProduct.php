<?php

//ovo je forma
session_start();

$host = 'localhost';
$dbname = 'korisnici';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Povezivanje na bazu nije uspjelo: " . $conn->connect_error);
}

// Provjera je li ID proizvoda poslan putem GET-a
if (!isset($_GET['id'])) {
    die("ID proizvoda nije naveden.");
}

$product_id = $_GET['id']; 

// Dohvati trenutne podatke proizvoda iz baze
$sql = "SELECT * FROM proizvodi WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Proizvod nije pronaden.");
}

$product = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uredi proizvod</title>
</head>
<body>
    <h2>Uredi proizvod</h2>
    <form action="/project/konzola/edit_product.php" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

        <label for="naziv">Naziv proizvoda:</label>
        <input type="text" id="naziv" name="naziv" value="<?php echo $product['naziv']; ?>" required><br><br>
        
        <label for="opis">Opis proizvoda:</label>
        <input type="text" id="opis" name="opis" value="<?php echo $product['opis']; ?>" required><br><br>
        
        <label for="cijena">Cijena (EUR):</label>
        <input type="number" id="cijena" name="cijena" value="<?php echo $product['cijena']; ?>" step="0.01" required><br><br>
        
        <label for="slika_url">URL slike:</label>
        <input type="text" id="slika_url" name="slika_url" value="<?php echo $product['slika']; ?>" placeholder="Unesite URL slike" required><br><br>

        <button type="submit">Spremi promjene</button>
        <a href="/project/konzola/konzola.html">Vrati se</a>
    </form>
</body>
</html>

<?php
$conn->close();
?>
