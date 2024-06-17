<?php
session_start();
header('Content-Type: application/json');
require 'config.php';
$response=[];
$jobtitlesk=[];
$fulldat = [];
$jobtitlecodes = [];
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $srxterm = $_POST['Searched'] ?? '';
        $response['searched']=$srxterm;
        if($srxterm){
            $searchTerm = strtolower($srxterm); // Convert search term to lowercase
            $sql = "SELECT * FROM Recruitmentdetails WHERE LOWER(Jobtitle) LIKE ?";
            $stmt = $conn->prepare($sql);
            $likeTerm = "%" . $searchTerm . "%";
            $stmt->bind_param("s", $likeTerm);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()){
                $jobtitlecodes[] = $row['JobtitleCode'];
                $jobtitlesk[] = $row['Jobtitle'];
                $fulldat[] = $row;
            }
            $result->free();
            $stmt->close();
        }
    }
$response['fulldetail']= $fulldat;             
$response['jbtitles'] = $jobtitlesk;
$response['Jobtitlecode'] = $jobtitlecodes;
}catch(Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
} 

echo json_encode($response);
