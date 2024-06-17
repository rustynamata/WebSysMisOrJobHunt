<?php
session_start();
require 'config.php';
header('Content-Type: application/json');
$response = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $notif ;
    $jobtt =    $_POST['jobtt'] ?? '';
    $jobcode = $_POST['jobcode'] ?? '';
    $id = $_POST['id'] ?? '';
    $from = $_POST['from'] ?? '';
    $notfier = $_SESSION['userid'];
    $notifiersName = $_SESSION['firstname'];
    
    if($from && $from != "recruiter") {
        $stmt1 = $conn->prepare("insert into `$id` (notifierID, notifierFname, notification, JobtitleCode) values(?,?,?,?)") ;
        $notif = "An applicant $notifiersName Applied to your Job Opening $jobtt" ;
        $stmt1->bind_param("isss", $notfier ,$notifiersName, $notif, $jobcode);
        $stmt1->execute();
    }else{
        $stmt = $conn->prepare("insert into `$id` (notifierID, notifierFname, notification) values(?,?,?)");
        $notif = "The Recruiter $notifiersName is Interested in you provideWait for an Email" ;
        $stmt->bind_param("iss", $notfier ,$notifiersName, $notif);
        $stmt->execute();
    }
    $response['success']=true;
}
echo json_encode($response);