let keypress = 0;

function submitEmail() {
    keypress++;

    let email = document.getElementById('email').value;
    console.log(`Submitting email: ${email}`);
    
    let formData = new FormData();
    formData.append('Email', email);

    fetch('../php/checkemailexist.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response from checkemailexist.php:', data);
        if (data.success) {
            let forgotFormData = new FormData();
            forgotFormData.append('Email', email);
            forgotFormData.append('forgot', true);

            fetch('../php/forgot.php', {
                method: 'POST',
                body: forgotFormData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response from forgot.php:', data);
                if (data.success) {
                    let otp = document.querySelector('.popup');
                    otp.style.display = 'flex';
                    
                } else {
                    console.error('Error in forgot.php:', data);
                }
            })
            .catch(error => console.error('Fetch error in forgot.php:', error));
        } else {
            console.error('Error in checkemailexist.php:', data);
        }
    })
    .catch(error => console.error('Fetch error in checkemailexist.php:', error));
}

function confirm() {
    let otp1 = document.getElementById('otp').value;
    console.log(`Confirming OTP: ${otp1}`);
    
    let formData = new FormData();
    formData.append('code', otp1);

    fetch('../php/verificationGenerator.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response from verificationGenerator.php (confirm):', data);
        if (data.success) {
            let otp = document.querySelector('.popup');
            otp.style.display = 'none';
            let psdiv = document.getElementById("hide");
            psdiv.style.display = 'block';
            let button1 = document.getElementById("submit1");
            button1.style.display="none";
            let button2 = document.getElementById("submit2");
            button2.style.display="block";
        } else {
            console.error('Error in verificationGenerator.php (confirm):', data);
        }
    })
    .catch(error => console.error('Fetch error in verificationGenerator.php (confirm):', error));
}

function update() {
    let pass = document.querySelector('.pss').value;
    let retype = document.querySelector('.rpas').value;

    console.log(`Updating password: ${pass}, Retype: ${retype}`);
    
    let formData = new FormData();
    formData.append('pass', pass);
    formData.append('retype', retype);

    fetch('../php/updatepask.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Response from updatepask.php (update):', data);
        if (data.success) {
            window.location.href = "../html/log_in.html";
        } else {
            let prompt = document.getElementById('prompt');
            if (prompt) {
                prompt.textContent = data.message;
            }
            console.error('Error in updatepask.php (update):', data.message);
        }
    })
    .catch(error => console.error('Fetch error in updatepask.php (update):', error));
}

