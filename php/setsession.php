<?php
session_start();
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usecode = $_POST['id'] ?? '';
    $_SESSION['idFROMrecDash'] = $usecode;}
echo json_encode(true);
