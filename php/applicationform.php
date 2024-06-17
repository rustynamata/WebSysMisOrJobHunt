<?php
session_start();
header('Content-Type: application/json');
require 'config.php';

$response = [];
$response['email']=$_SESSION['email'];
$email=$_SESSION['email'];

try {
    // Get the JSON data from the FormData
    if (isset($_POST['jsonData'])) {
        $jsonData = json_decode($_POST['jsonData'], true);
        if ($jsonData === null) {
            throw new Exception("Failed to decode JSON data.");
        }

        // Insert main form data
        $stmt = $conn->prepare("
            INSERT INTO users (FirstName, LastName, mid_name, Email, Usertype, password, sex, age, birthdate, address, civil_status, nationality, phone, messenger_link) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)
        ");
        $stmt->bind_param(
            'ssssssssssssss',
            $jsonData['firstName'],
            $jsonData['lastName'],
            $jsonData['midname'],
            $email,
            $_SESSION['usertype'],
            $_SESSION['password'],
            $jsonData['sex'],
            $jsonData['age'],
            $jsonData['birthdate'],
            $jsonData['address'],
            $jsonData['civilStatus'],
            $jsonData['nationality'],
            $jsonData['phone'],
            $jsonData['messengerLink']
        );
        $stmt->execute();
        $userId = $stmt->insert_id;
        $_SESSION['userid'] = $userId;
        $_SESSION['firstname'] = $jsonData['firstName'];
        $last_id = $conn->insert_id;
        $sql =  "CREATE TABLE IF NOT EXISTS `$last_id`(
        notifierID int,
        notifierFname VARCHAR(255),
        notification VARCHAR(255),
        Status VARCHAR(30),
        FOREIGN KEY (notifierID) REFERENCES users(id) ON DELETE CASCADE
        );";
       $result1 = $conn->query($sql);
        // Insert educational data
        $insertEducation = function($userId, $data, $table, $prefixinf) use ($conn) {
            foreach ($data as $entry) {
                $stmt = $conn->prepare("
                    INSERT INTO $table (user_id, SchoolName, SchoolAddress, Level, Year) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->bind_param(
                    'issss',
                    $userId,
                    $entry[ str_replace(' ', '', "$prefixinf SN")],
                    $entry[str_replace(' ', '', "$prefixinf SA")],
                    $entry[str_replace(' ', '', "$prefixinf lvl")],
                    $entry[str_replace(' ', '', "$prefixinf YR")]
                );
                $stmt->execute();
                $stmt->close();
            }
        };

        $insertEducation($userId, $jsonData['elemdata'], 'education_elementary','elem');
        $insertEducation($userId, $jsonData['hsdata'], 'education_highschool','hs');
        $insertEducation($userId, $jsonData['coldata'], 'education_college','col');

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

