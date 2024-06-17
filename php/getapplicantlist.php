<?php
session_start();
header('Content-Type: application/json');
require 'config.php';
$response=[];
$all =[];
$applicantDetails = [];
$fulldetails = [];
$userId = $_SESSION['userid'];
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $jobcode = $_POST['jobtitlecode'] ?? '';
        $sql =$conn->prepare("SELECT * FROM `$userId` WHERE JobtitleCode = ?");
        $sql->bind_param('s', $jobcode);
        $sql->execute();
        $result = $sql->get_result();
        while ($row = $result->fetch_assoc()){
            $all[] = $row;
        }
        if ($all) {
            foreach ($all as $applicant) {
                $stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
                $stmt->bind_param('i', $applicant['notifierID']);
                $stmt->execute();
                $result1 = $stmt->get_result();
                if ($result1->num_rows > 0) {
                    $row = $result1->fetch_assoc();
                    $applicantDetails[] = [$row['id'],$row['FirstName'],$row['LastName']];
                    $fulldetails[]=$row;
                }
                $result1->free();
                $stmt->close();
            }
        }
    }
$response['fulldetail']= $fulldetails;             
$response['applicantdet']=$applicantDetails;
$response['applicantsId']=$all;
}catch(Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
} 

echo json_encode($response);
