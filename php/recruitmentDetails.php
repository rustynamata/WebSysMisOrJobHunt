<?php
session_start();
require 'config.php';
header('Content-Type: application/json');
$response = [];
$data = [];
$section = [];
$Key_Responsibilities = [];
$Other_Requirements = [];
$SkillandCompetency = [];
$WorkingCondition = [];
$CompensationBenefits = [];
$HowToApply = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $button_id = $_POST['jobtitlecode'];

    // Query the database using the button ID
    $stmt = $conn->prepare("SELECT * FROM Recruitmentdetails WHERE JobtitleCode = ?");
    $stmt->bind_param("s", $button_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; // Change 'your_column' to the actual column name
        }
        $stmt->close();
        $response['success']=true;
    } else {
       $response['error']= "No data found";
    }

    $stmt = $conn->prepare("SELECT * FROM MultiEntry WHERE JobtitleCode = ?");
    $stmt->bind_param("s", $button_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; 
            $sect = $row["Sections"];
            $caption = $row["Captions"]; // Assuming Captions is the actual data you want to store
            if ($sect === 'Key_Responsibilities') {
                $Key_Responsibilities[] = $caption;
            } elseif ($sect === 'Other_Requirements') {
                $Other_Requirements[] = $caption;
            } elseif ($sect === 'SkillandCompetency') {
                $SkillandCompetency[] = $caption;
            } elseif ($sect === 'WorkingCondition') {
                $WorkingCondition[] = $caption;
            } elseif ($sect === 'CompensationBenefits') {
                $CompensationBenefits[] = $caption;
            } elseif ($sect === 'HowToApply') {
                $HowToApply[] = $caption;
            }
        }
        $stmt->close();
        $response['success']=true;
    }else{
        $response['error']= "No data found";
    }



    $_SESSION['data']=$data;
    $_SESSION['Key_Responsibilities'] = $Key_Responsibilities;
    $_SESSION['Other_Requirements'] = $Other_Requirements;
    $_SESSION['SkillandCompetency'] = $SkillandCompetency;
    $_SESSION['WorkingCondition'] = $WorkingCondition;
    $_SESSION['CompensationBenefits'] = $CompensationBenefits;
    $_SESSION['HowToApply'] = $HowToApply;

} else {
    $response['error']= "No button ID provided.";
}
echo json_encode($response);

