<?php
session_start();

header('Content-Type: application/json'); 

if (isset($_SESSION['prijavljen']) && $_SESSION['prijavljen'] === true) {
    echo json_encode([
        'status' => 'success',
        'ime' => $_SESSION['ime'],
        'prezime' => $_SESSION['prezime'],
        'uloga' => $_SESSION['uloga']
    ]);
} else {
    echo json_encode(['status' => 'not_logged_in']);
}
?>
