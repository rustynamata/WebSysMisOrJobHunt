<?php
session_start();
header('Content-Type: application/json');
require 'config.php';

$response = [];
$response['email']=$_SESSION['email'];
$email=$_SESSION['email'];
$userId = $_SESSION['userid'];
$response['USERID'] = $userId;

$time = date("YmdHis");

try {
    // Get the JSON data from the FormData
    if (isset($_POST['jsonData'])) {
        $jsonData = json_decode($_POST['jsonData'], true);
        if ($jsonData === null) {
            throw new Exception("Failed to decode JSON data.");
        }
        $jobtitle = preg_replace('/\s+/', '', $jsonData['jobtitle'].$userId.$time);
        $stmt = $conn->prepare("
        INSERT INTO Recruitmentdetails (user_id,JobtitleCode, Jobtitle, AddressMunicipality, AddressProvince, CompanyName, EmploymentType, JobSummary, HighestEducAttainment, Experience, Salary) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            'issssssssss',
            $userId,
            $jobtitle,
            $jsonData['jobtitle'],
            $jsonData['companyname'],
            $jsonData['munadd'],
            $jsonData['proadd'],
            $jsonData['jobtype'],
            $jsonData['jobsummary'],
            $jsonData['educlevel'],
            $jsonData['workingexp'],
            $jsonData['salary'],
        );
        $stmt->execute();
        
        // Insert educational data
        $insertEducation = function($data, $section) use ($conn, $jobtitle) {
            foreach ($data as $entry) {
                $stmt = $conn->prepare("
                    INSERT INTO MultiEntry (JobtitleCode, Sections, Captions) 
                    VALUES (?, ?, ?)
                ");
                if ($stmt === false) {
                    throw new Exception('Failed to prepare statement: ' . $conn->error);
                }
                $stmt->bind_param(
                    'sss',
                    $jobtitle,
                    $section,
                    $entry // Each string in $data is used as the caption
                );
                $stmt->execute();
                $stmt->close();
            }
        };        
        $insertEducation( $jsonData['keyresponsibility'], 'Key_Responsibilities');
        $insertEducation( $jsonData['otherequirement'], 'Other_Requirements');
        $insertEducation( $jsonData['skillandcomp'], 'SkillandCompetency');
        $insertEducation( $jsonData['workingcondition'], 'WorkingCondition');
        $insertEducation( $jsonData['compensation'], 'CompensationBenefits');
        $insertEducation( $jsonData['skillandcomp'], 'SkillandCompetency');
        $insertEducation( $jsonData['hotoapply'], 'HowToApply');

        $stmt1 = $conn->prepare( "CREATE TABLE IF NOT EXISTS `$jobtitle`(
            APPLICANTSid int(255) NOT NULL,
            FOREIGN KEY (APPLICANTSid) REFERENCES users(id) ON DELETE CASCADE
        );");
        $stmt1->execute();

        $response['status'] = 'success';
        $response['message'] = 'Data submitted successfully.';
    } else {
        throw new Exception("No JSON data received.");
    }
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
} 
echo json_encode($response);
