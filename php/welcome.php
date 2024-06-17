<?php
session_start();
$username = array('FirstName'=>'empty', 'message' =>'empty', 'success' => false);
header('Content-Type: application/json');
if (isset($_SESSION['email'])) {
   $username['FirstName']= $_SESSION['email'];
   $username['success'] = true;
} else {
    $username['message']="Session Empty";
}

echo json_encode($username);
?>