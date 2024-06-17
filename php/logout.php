<?php
// logout.php
session_start();
session_unset();
session_destroy();
header("Location: ../html/index.html"); // Redirect to login page or home page
exit();

