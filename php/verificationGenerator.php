<?php
require 'config.php';
session_start();
$vericode = $_SESSION['vericode'];
$response=[];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $code = $_POST['code'] ?? '';
    if($code){
        if($code===strval($vericode)){
            $response['success']=true;
            
        }else{
            $response['message']='Please Try Again!';
        }
    }else{
        $response['message'] = 'Please Enter the Verification Code!';
    }
}

echo json_encode($response);
