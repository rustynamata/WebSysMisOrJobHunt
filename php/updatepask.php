<?php
session_start();
header('Content-Type: application/json');
require 'config.php';

$response = [];
$response['email']=$_SESSION['email'];
$email=$_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pass = $_POST['pass'] ?? '';
    $retype = $_POST['retype'] ?? '';
    $email = $_SESSION['email'];

if ($pass === $retype) {
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE Email = ?");
$stmt->bind_param("ss", $pass, $email);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    $response["success"] = true;
    $response['message']= "Password updated successfully";
} else {
    $response['message']=  "Error updating record: " . $stmt->error;
}
} else {
    $response['message']="The retype password did not match!";
}
}
echo json_encode($response);
