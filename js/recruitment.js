document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("Save").addEventListener("click", function (event) {
    event.preventDefault();
    let prompt = document.querySelector(".prompt");
    let companyName = document.getElementById("comp_name").value;
    let jobtitle = document.getElementById("Job_tt").value;
    let employmenType = document.getElementById("jobtype").value;
    let jobsummary = document.getElementById("job_sm").value;
    let responsibilities = document.getElementById("key_r");
    let resListcont = document.getElementsByClassName("resList");
    let reslistbtn = document.getElementById("resList");
    let form =  document.querySelectorAll('input[type="text"], input[type="number"]');

/*
    let responsibilities = document.getElementById("key_r").value;
    let responsibilities = document.getElementById("key_r").value;
    let responsibilities = document.getElementById("key_r").value;
    let responsibilities = document.getElementById("key_r").value;
    let responsibilities = document.getElementById("key_r").value;
    let responsibilities = document.getElementById("key_r").value;

*/   

    reslistbtn.addEventListener('click', function () {
        const newInput = document.createElement('textarea');
        newInput.classList.add('inputText');
        resListcont.appendChild(newInput);
        fill_out.forEach(input => input.removeAttribute('required'));
    });
    
    console.log("Password:", password);
    if (initial){
        let usertype = initial.value;
        let formData = new FormData();
            formData.append("FName", firstName);
            formData.append("LName", lastName);
            formData.append("Email", email);
            formData.append("username", usertype);
            formData.append("password", password);
    
            fetch('../php/register.php', {
                method: 'POST',
                body: formData
                })
            .then(response => response.json())
            .then(data => {
            if (data.success) {
                prompt.textContent = "Registration successful!";
                prompt.style.color = "green";
                document.getElementsByClassName(".dinput").value='';
                var dradios = document.querySelectorAll("input[name=dradio]");
                dradios.forEach(function(radio) {
                radio.checked = false;})
                setTimeout(function() {
                    window.location.href = "log_in.html";
                }, 3000);
            } else {
                prompt.textContent = "Registration failed: " + data.message;
                prompt.style.color = "red";
            }
            })
            .catch(error => {
                prompt.textContent = "An error occurred: " + error.message;
                prompt.style.color = "red";
                });
        }else{
            prompt.textContent = "Select User Type!";
        }
    
        });
    });