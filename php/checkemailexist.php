<?php
session_start();
header('Content-Type: application/json');
require 'config.php';
$response=["success"=> false];
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['Email'];
    $stmt = $conn->prepare( "SELECT Email FROM users WHERE Email = ?");
    $stmt->bind_param('s', $email);
    $result = $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if($row ){
        $response["success"] = true;
    }else{
        $response["success"] = false;
    }

}
echo json_encode($response);