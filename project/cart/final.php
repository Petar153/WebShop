<?php
session_start();

$host = 'localhost'; 
$dbname = 'korisnici'; 
$username = 'root'; 
$password = ''; /

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Povezivanje na bazu nije uspjelo: " . $conn->connect_error);
}

// Provjera da li je korisnik prijavljen
if (!isset($_SESSION['user_id'])) {
    die("Morate biti prijavljeni za izvrsenje kupovine.");
}


$user_id = $_SESSION['user_id'];
$korisnik_id = $_SESSION['user_id'];
$ukupna_cijena = $_POST['ukupnaCijenaDefault'];
$metoda_dostave = $_POST['metoda_dostave'];
$ime_prezime = $_POST['fullName'];
$adresa = $_POST['address'];
$email = $_POST['email'];
$telefon = $_POST['phone'];


// Dohvati proizvode u kosarici
$sql = "SELECT p.id, p.naziv, p.cijena, k.kolicina FROM kosarica k
        JOIN proizvodi p ON k.proizvod_id = p.id
        WHERE k.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$kosarica = [];

while ($row = $result->fetch_assoc()) {
    $kosarica[] = $row;
    
}

if (empty($kosarica)) {
    die("Kosarica je prazna.");
}


// Unos narudzbe u tablicu narudzbe
$query = "INSERT INTO narudzbe (korisnik_id, ukupna_cijena, metoda_dostave, ime_prezime, adresa, email, telefon)
          VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param('idsssss', $korisnik_id, $ukupna_cijena, $metoda_dostave, $ime_prezime, $adresa, $email, $telefon);
$stmt->execute();

// Dohvati ID novonastale narudzbe
$narudzba_id = $stmt->insert_id;



// Unos proizvoda u tablicu narudzba_proizvodi
foreach ($kosarica as $item) {
    $sql = "INSERT INTO narudzba_proizvodi (narudzba_id, proizvod_id, kolicina, cijena, ukupna_cijena) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $total_price = $item['cijena'] * $item['kolicina'];
    $stmt->bind_param('iiidd', $narudzba_id, $item['id'], $item['kolicina'], $item['cijena'], $total_price);
    $stmt->execute();
}
    
// Brisanje proizvoda iz kosarice nakon izvrsene narudzbe
$sql = "DELETE FROM kosarica WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();

echo "Narudzba uspjesno izvrsena! Hvala na kupovini.";

?>
