<?php
$conn = new mysqli('localhost','root','');
if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);}
$sql ="CREATE DATABASE IF NOT EXISTS test";
if ($conn->query($sql) === TRUE) {
        $er =  "Table created successfully";
    } else {
        $er =  "Error creating table: " . $conn->error;
    }
$conn = new mysqli('localhost','root','','test');
    if($conn->connect_error){
        echo "$conn->connect_error";
        die("Connection Failed : ". $conn->connect_error);}
        
$sql1 = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(255),
    LastName VARCHAR(255),
    mid_name VARCHAR(255),
    Email VARCHAR(255) UNIQUE,
    Usertype VARCHAR(255),
    password VARCHAR(255),
    sex VARCHAR(10),
    age INT,
    birthdate DATE,
    address TEXT,
    civil_status VARCHAR(50),
    nationality VARCHAR(50),
    phone VARCHAR(20),
    messenger_link TEXT
);";
$sql2="CREATE TABLE IF NOT EXISTS education_elementary (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    SchoolName VARCHAR(255),
    SchoolAddress VARCHAR(255),
    Level VARCHAR(50),
    Year VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);";
$sql3 ="CREATE TABLE IF NOT EXISTS education_highschool (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    SchoolName VARCHAR(255),
    SchoolAddress VARCHAR(255),
    Level VARCHAR(50),
    Year VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE);";

$sql4 ="CREATE TABLE IF NOT EXISTS education_college (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    SchoolName VARCHAR(255),
    SchoolAddress VARCHAR(255),
    Level VARCHAR(50),
    Year VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);";
$sql5 ="CREATE TABLE IF NOT EXISTS Recruitmentdetails (
    user_id INT,
    JobtitleCode VARCHAR(255) PRIMARY KEY,
    Jobtitle VARCHAR(255),
    AddressMunicipality VARCHAR(255),
    AddressProvince VARCHAR(255),
    CompanyName VARCHAR(255),
    EmploymentType VARCHAR(255),
    JobSummary MEDIUMTEXT,
    Date DATETIME DEFAULT CURRENT_TIMESTAMP,
    HighestEducAttainment VARCHAR(255),
    Experience VARCHAR(255),
    Salary DOUBLE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);";

$sql6 ="CREATE TABLE IF NOT EXISTS MultiEntry(
    JobtitleCode VARCHAR(255),
    Date DATETIME DEFAULT CURRENT_TIMESTAMP,
    Sections VARCHAR(255),
    Captions MEDIUMTEXT,
    FOREIGN KEY (JobtitleCode) REFERENCES Recruitmentdetails(JobtitleCode) ON DELETE CASCADE
);";

$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result4 = $conn->query($sql4);
$result5 = $conn->query($sql5);
$result6 = $conn->query($sql6);



// Check for errors
if ($result1 === true && $result2 === true && $result3 === true && $result4 === true && $result5 === true && $result6 === true) {
    $er =  "Tables created successfully.";
} else {
    $er="Error creating tables: " . $conn->error;
}