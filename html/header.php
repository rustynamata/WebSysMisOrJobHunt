<?php
session_start();
header('Content-Type: application/json');
$isLoggedIn = isset($_SESSION['email']);
$usertype = '';
$email = '';
$user_id = '';

if ($isLoggedIn) {
    $usertype = $_SESSION['usertype'];
    $email = $_SESSION['email'];
    $user_id = $_SESSION['userid'];
    $fname = $_SESSION['firstname'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        header {
            width: 100%;
            height:50px;
            padding: 5px 0;
            background-color: rgba(128, 128, 128, .6);
            
        }
        nav {
            display: flex;
            justify-content: flex-end;
            align-self: flex-end;
            margin-right: 30px;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            font-size: 25px;
        }
        nav ul li {
            display: flex;
            margin-left: 15px;
        }
        nav a {
            color: #000;
            text-decoration: none;
            font-weight: bold;
        }
        nav img {
            background-color: none;
            width: 30px;
            aspect-ratio: 1/1;
            object-fit: contain;
            mix-blend-mode: color-dodge;
        }
        #dropdown {
            display: none;
            z-index: 1;
            position: absolute;
            background-color: whitesmoke;
            padding: 10px;
            width: 100px;
            margin-top: 20px;
            margin-right: 10px;
            right: 10px;
            cursor: pointer;
        }
        p{
            font-size: 20px;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <ul id="navList">
            <?php if ($isLoggedIn): ?>
                <li><a href="notification.php">Notification</a></li>
                <li><button id="<?php echo $user_id; ?>" onclick="kickedbutton(this)"><img src="../images/images.png"></button></li>
                
            <?php else: ?>
                <li><a href="log_in.html">Login</a></li>
                <li><a href="register.html">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div id="dropdown">
    <p><?php echo htmlspecialchars($fname);?></p>
        <a class="dshm"></a>
        <a id="logout" onclick="logout()">Log-out</a>
    </div>
</header>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("DOM fully loaded and parsed");

        // Get the usertype and email values from PHP
        let usertype = <?php echo json_encode($usertype); ?>;
        let email = <?php echo json_encode($email); ?>;
        console.log("usertype:", usertype);
        console.log("email:", email);

        // Select the element with the class 'dshm'
        let dshm = document.querySelector(".dshm");
        console.log("dshm element:", dshm);

        // Check if the element 'dshm' is found
        if (dshm) {
            // Assign different actions based on the usertype
            if (usertype === "Applicant") {
                dshm.onclick = function () {
                    console.log("Navigating to index.html");
                    location.href = "index.html";
                };
                dshm.textContent = "Home";
            } else {
                dshm.onclick = function () {
                    console.log("Navigating to recruiter_dashboard.html");
                    location.href = "recruiter_dashboard.html";
                };
                dshm.textContent = "Dashboard";
            }
        } else {
            console.error("Element with class 'dshm' not found.");
        }

        // Log debug information
        console.log("Script executed");
    });

    function kickedbutton(button) {
        event.preventDefault();
        let dpd = document.getElementById('dropdown');
        dpd.style.display = "block";
        const buttonid = button.id;
        console.log(buttonid);
        let usertype = <?php echo json_encode($usertype); ?>;
        let email = <?php echo json_encode($email); ?>;
        console.log("usertype:", usertype);
        console.log("email:", email);

        // Select the element with the class 'dshm'
        let dshm = document.querySelector(".dshm");
        console.log("dshm element:", dshm);

        // Check if the element 'dshm' is found
        if (dshm) {
            // Assign different actions based on the usertype
            if (usertype === "Applicant") {
                dshm.onclick = function () {
                    console.log("Navigating to index.html");
                    location.href = "index.html";
                };
                dshm.textContent = "Home";
            } else {
                dshm.onclick = function () {
                    console.log("Navigating to recruiter_dashboard.html");
                    location.href = "recruiter_dashboard.html";
                };
                dshm.textContent = "Dashboard";
            }
        } else {
            console.error("Element with class 'dshm' not found.");
        }

        // Log debug information
        console.log("Script executed");

    }

    function logout() {
        window.location.href = '../php/logout.php';
    }
</script>
</body>
</html>
