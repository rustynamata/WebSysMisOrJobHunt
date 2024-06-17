document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("Login").addEventListener("click", function (event) {
        event.preventDefault();
        let prompt = document.querySelector(".prompt");
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;

        let formData = new FormData();
        formData.append("Email", email);
        formData.append("password", password);

        fetch('../php/log_in.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                prompt.textContent = "Login successful!";
                prompt.style.color = "green";
                // Redirect to a different page on successful login
                if(data.usertype == 'Applicant'){
                    window.location.href = "index.html"; 
                }else{
                    window.location.href = "recruiter_dashboard.html";
                }// Example redirect
            } else {
                prompt.textContent = "Login failed: " + data.message;
                prompt.style.color = "red";
            }
        })
        .catch(error => {
            prompt.textContent = "An error occurred: " + error.message;
            prompt.style.color = "red";
        });
    });
});
