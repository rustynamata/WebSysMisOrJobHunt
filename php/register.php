<?php
session_start();
include('config.php');
// Set the Content-Type header to application/json
header('Content-Type: application/json');

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
        

        $_SESSION['email'] = $_POST['Email'];
        $_SESSION['usertype'] = $usertype;
        $_SESSION['password'] = $password;
        if($usertype=='Recruiter'){
            try {
                $stmt = $conn->prepare("insert into users (FirstName, LastName, Email, Usertype, password) values(?, ?, ?, ?,?)");
                $stmt->bind_param('sssss',$firstName, $lastName, $email, $usertype, $password);
                $execval = $stmt->execute();
                $last_id = $conn->insert_id;
                $sql =  "CREATE TABLE IF NOT EXISTS `$last_id`(
                    notifierID int,
                    notifierFname VARCHAR(255),
                    notification VARCHAR(255),
                    JobtitleCode VARCHAR(255),
                    Status VARCHAR(30),
                    FOREIGN KEY (notifierID) REFERENCES users(id) ON DELETE CASCADE,
                    FOREIGN KEY (JobtitleCode) REFERENCES Recruitmentdetails(JobtitleCode) ON DELETE CASCADE
                    );";
                $result = $conn->query($sql);
                $_SESSION['userid']= $last_id;
                 } 
                 catch (mysqli_sql_exception $e) {
                    if ($e->getCode() == 1062) {
                        $response['message']="Cannot Register an Existing Email";
                    } else {
                        $response['message']= "Error: " . $e->getMessage() . "\n";
                        }
                }       
                $response['success'] = true;
                $response['message'] = 'Registration successful';
           
        // Here you can add your code to save the data to a database or perform other actions
        }else{
            $response['gotoapplicationform'] =true;
            
               
        }
    }
$response['message'] .= $er;
$response['email'] = $email;
$response['email2'] = $_SESSION['email'];

// Output the JSON response
$tobeko = json_encode($response);
echo $tobeko;
