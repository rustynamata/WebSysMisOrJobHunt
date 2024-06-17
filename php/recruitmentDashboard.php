<?php
session_start();
header('Content-Type: application/json');
require 'config.php';

$response = [];
$jobtitlesk=[];
$fulldat = [];
$jobtitlecodes = [];
$response['email']=$_SESSION['email'];
$email=$_SESSION['email'];
try {
    $stmt = $conn->prepare('SELECT id, FirstName, Email, Usertype,password FROM users WHERE Email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($db_userid, $db_firstname, $db_email, $db_usertype, $db_password);
    $stmt->fetch();
    
    $stmt = $conn->prepare('SELECT JobtitleCode, Jobtitle, CompanyName, EmploymentType, JobSummary, HighestEducAttainment, Experience, Salary FROM Recruitmentdetails WHERE user_id = ?');
    $stmt->bind_param('s', $db_userid);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()){
        $jobtitlecodes[] = $row['JobtitleCode'];
        $jobtitlesk[] = $row['Jobtitle'];
        $fulldat[] = $row;
    }
$response['jbtitles'] = $jobtitlesk;
$response['Jobtitlecode'] = $jobtitlecodes;
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
} 

echo json_encode($response);

