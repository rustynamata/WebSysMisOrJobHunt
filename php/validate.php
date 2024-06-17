<?php
session_start();
include('config.php');
// Set the Content-Type header to application/json
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->isSMTP();
// Initialize the response array
$response = array('success' => false, 'message' => '');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['FName'] ?? '';
    $lastName = $_POST['LName'] ?? '';
    $email = $_POST['Email'] ?? '';
    $usertype = $_POST['Usertype'] ?? '';
    $password = $_POST['password'] ?? '';
    $forgot = $_POST['forgot'] ??'';



    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $response['message'] = 'Please fill in all required fields';
    }else{ 
        try{$verificationCode = rand(100000, 999999);
        $_SESSION['vericode'] = $verificationCode;
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true; 
        $mail->Username   = 'lorem.ipsum.sample.email@gmail.com';
        $mail->Password   = 'novtycchbrhfyddx';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;         
        $mail->setFrom('namata.rusty1@gmail.com', 'Mis-Or JobHunt');
        $mail->addAddress($email);   
        $mail->addReplyTo('namata.rusty1@gmail.com', 'Mis-Or JobHunt'); 
        $mailInfo = [
            'to' => $mail->getToAddresses(),
            'subject' => $mail->Subject,
            // Add more fields as needed
        ];
            //unset($associativeArray["email"]);
        $mail->isHTML(true);  
        $mail->Subject = 'Verification Code';
        $mail->Body    = 'Your verification code is: ' . $verificationCode;  
        $mail->send();
        $response['success']=true;
        $_SESSION['email']= $email;
        $response['mailInfo'] = $mailInfo;

    }catch (Exception $e) {
        // If an error occurs while sending the email, prepare an error message
        $response = [
            'success' => false,
            'message' => 'Email could not be sent. Error: ' . $mail->ErrorInfo
        ];
    }

}
}

echo json_encode($response);
