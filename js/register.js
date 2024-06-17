document.addEventListener("DOMContentLoaded", () => {
     

document.getElementById("Register").addEventListener("click", function (event) {
event.preventDefault();
    let prompt = document.querySelector(".prompt");
    let firstName = document.getElementById("FName").value;
    let lastName = document.getElementById("LName").value;
    let email = document.getElementById("Email").value;
    let initial = document.querySelector("input[name=UserType]:checked");
    let password = document.getElementById("password").value;
    if (initial){
        let usertype = initial.value;
        let formData = new FormData();
            formData.append("FName", firstName);
            formData.append("LName", lastName);
            formData.append("Email", email);
            formData.append("Usertype", usertype);
            formData.append("password", password);
            fetch('../php/validate.php', {
                method: 'POST',
                body: formData
                })
            .then(response => response.json())
            .then(data => {
            if (data.success) {
                popupBox.style.display = "flex";
            }else{
                prompt.textContent = "Registration failed: " + data.message;
                prompt.style.color = "red";
            }

            });
        }else{
            prompt.textContent = "Select User Type!";
        }
    });

    document.getElementById("confirm").addEventListener("click", function (event) {
        event.preventDefault();
        var inputs = document.querySelectorAll('.inputp');
        let prompt = document.querySelector(".prompt");
        let firstName = document.getElementById("FName").value;
        let lastName = document.getElementById("LName").value;
        let email = document.getElementById("Email").value;
        let initial = document.querySelector("input[name=UserType]:checked");
        let password = document.getElementById("password").value;
        var values = document.getElementById("otp").value;
        const overlayprompt = document.querySelector('overlayprompt');
        let op = document.querySelector(".overlayprompt");
        let formData1 = new FormData();
            formData1.append('code', values);
        fetch('../php/verificationGenerator.php', {
            method: 'POST',
            body: formData1
            })
        .then(response => response.json())
        .then(data => {
        if (data.success) {
            op
            let formData = new FormData();
    
            console.log("Password:", password);
            if (initial){
                let usertype = initial.value;
                let formData = new FormData();
                    formData.append("FName", firstName);
                    formData.append("LName", lastName);
                    formData.append("Email", email);
                    formData.append("Usertype", usertype);
                    formData.append("password", password);
            
                    fetch('../php/register.php', {
                        method: 'POST',
                        body: formData
                        })
                    .then(response => response.json())
                    .then(data => {
                    if (data.success || data.gotoapplicationform) {
                        prompt.textContent = "Registration successful!"+data.email+data.email2+email;
                        prompt.style.color = "green";
                        document.getElementsByClassName(".dinput").value='';
            
                        var dradios = document.querySelectorAll("input[name=dradio]");
                        dradios.forEach(function(radio) {
                        radio.checked = false;})
                        if(usertype =='Applicant'){
                            window.location.href = "application_form.html";
                            console.log(data.email)
                            console.log(data.email2)
                        }else{
                            window.location.href = "log_in.html";
                        }
            
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
            }else{
                overlayprompt.textContent =data.message;
    
            }
    
        });
    });
});