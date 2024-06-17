<?php
session_start();
require '../php/config.php';
$fulldata = [];
$details = [];
$applicant = $_SESSION['idFROMrecDash'];

// Prepare and execute statement once
$stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
$stmt->bind_param('i', $applicant);
$stmt->execute();
$result1 = $stmt->get_result();
if ($result1->num_rows > 0) {
    $row = $result1->fetch_assoc();
    $fulldata[] = $row;
}
$result1->free();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Profile</title>
    <link rel="stylesheet" href="../css/applicantprofile.css">
</head>
<body>
    <div class="container">
        <h2>Applicant Profile</h2>
        <div class="profile">
            <div class="profile-item">
                <span class="label">Full Name:</span>
                <span class="value" id="fullName"><?php echo $fulldata[0]['FirstName']." " .$fulldata[0]['LastName']?></span>
            </div>
            <div class="profile-item">
                <span class="label">Email:</span>
                <span class="value" id="email"><?php echo $fulldata[0]['Email']?></span>
            </div>
            <div class="profile-item">
                <span class="label">Phone Number:</span>
                <span class="value" id="phone"><?php echo $fulldata[0]['phone']?></span>
            </div>
            <div class="profile-item">
                <span class="label">Address:</span>
                <span class="value" id="address"><?php echo $fulldata[0]['address']?></span>
            </div>
            <div class="profile-item">
                <span class="label">Higest Educational Attainment:</span>
                <span class="value" id="HighestEDuc"></span>
            </div>
        </div>
        <button id="interested" onclick="interestclick()">INTERESTED</button>
    </div>
    <script>
    function interestclick() {
        var userId = <?php echo json_encode($applicant); ?>;
        let formData = new FormData();
        formData.append('id', userId);
        formData.append('from', 'recruiter');
        formData.append('jobcode', '');
        formData.append('jobtt', '');  // Define jobtt properly or leave as empty string if not needed

        fetch('../php/notify.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Notification sent successfully');
            } else {
                console.log('Failed to send notification');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

        console.log(userId);
    }
    </script>
</body>
</html>
