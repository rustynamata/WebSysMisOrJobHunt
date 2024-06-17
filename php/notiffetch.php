<?php
session_start();
header('Content-Type: application/json');
require 'config.php';
$response = [];
$fulldat=[];
$response['email']=$_SESSION['email'];
$email=$_SESSION['email'];
$id = $_SESSION['userid'];
$stmt = $conn->prepare("SELECT * FROM `$id`");
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()){
    $fulldat[] = $row;
    }
    $result->free();
    $stmt->close();
$response['dataset'] = $fulldat;
echo json_encode($response);
