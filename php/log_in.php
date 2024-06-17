<?php
session_start();
require 'config.php'; // Ensure your config.php is included

// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Initialize the response array
$response = array('success' => false, 'message' => '', 'usertype'=>'');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect POST data
    $email = $_POST['Email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate input
    if (empty($email) || empty($password)) {
        $response['message'] = 'Please fill in all fields';
    } else {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare('SELECT id, FirstName, Email, Usertype,password FROM users WHERE Email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($db_userid, $db_firstname, $db_email, $db_usertype, $db_password);
            $stmt->fetch();
            $response['message'] = strval($stmt->num_rows)."\n";
            $response['message'].= $er;
            $response['usertype']=$db_usertype;

            // Verify password 
            if ($password == $db_password) {
                // Password is correct
                $_SESSION['firstname'] = $db_firstname;
                $_SESSION['email'] = $db_email;
                $_SESSION['usertype'] = $db_usertype;
                $_SESSION['userid'] = $db_userid;

                $response['success'] = true;
                $response['message'] .= 'Login successful';
            } else {
                // Invalid password
                $response['message'] .= 'Wrong password';
            }
        } else {
            // User not found
            $response['message'] .= 'Invalid username';
        }

        $stmt->close();
    }
} else {
    $response['message'] = 'Invalid request method';
}

// Output the JSON response
echo json_encode($response);

