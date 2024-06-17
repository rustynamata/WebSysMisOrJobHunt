async function loadDynamicContent() {
    try {
        const response = await fetch('header.php');
        if (response.ok) {
            const content = await response.text();
            document.getElementById('header-placeholder').innerHTML = content;
            evalScripts(content);
        } else {
            console.error('Failed to fetch content');
        }
    } catch (error) {
        console.error('Error fetching content:', error);
    }
}

function evalScripts(content) {
    const scriptMatches = content.match(/<script>([\s\S]*?)<\/script>/g) || [];
    scriptMatches.forEach(scriptTag => {
        const scriptContent = scriptTag.match(/<script>([\s\S]*?)<\/script>/)[1];
        const scriptElement = document.createElement('script');
        scriptElement.textContent = scriptContent;
        document.body.appendChild(scriptElement).parentNode.removeChild(scriptElement);
    });
}

document.addEventListener("DOMContentLoaded", () =>{
    const keyresbtn = document.getElementById('reslist');
    const reqqualbtn = document.getElementById('aders');
    const skcompbtn = document.getElementById('skcompbtn');
    const workconbtn = document.getElementById('workon');
    const compensben = document.getElementById('combenbtn');
    const howtobtn = document.getElementById('howtobtn');


    loadDynamicContent();

    function TextAreacreate(classSelector, elementcreated){
        const keyresdiv = document.querySelector(classSelector);
        let newtxtarearepons = document.createElement(elementcreated);
        keyresdiv.appendChild(newtxtarearepons);
    };
    
    function fetchevery(classelect){
        const inputTexts = document.querySelectorAll(classelect+' textarea');
        let values = [];
        inputTexts.forEach(function (inputText) {
        const inputValue = inputText.value.trim();
        if (inputValue !== '') {
                values.push(inputValue);
            }
        });
        return values;
    };

    keyresbtn.addEventListener('click', function (event) {
        event.preventDefault();
        // Create a new div element
        TextAreacreate('.resList',"textarea",);
    });

    reqqualbtn.addEventListener('click', function (event) {
        event.preventDefault();
        // Create a new div element
        TextAreacreate('.educ',"textarea");
    });

    skcompbtn.addEventListener('click', function (event) {
        event.preventDefault();
        // Create a new div element
        TextAreacreate('.skilldiv',"textarea");
    });

    workconbtn.addEventListener('click', function (event) {
        event.preventDefault();
        // Create a new div element
        TextAreacreate('.workondiv',"textarea");
    });
    
    compensben.addEventListener('click', function (event) {
        event.preventDefault();
        // Create a new div element
        TextAreacreate('.comben',"textarea");
            // Append the new div to the dynamic inputs container
    });
    howtobtn.addEventListener('click', function (event) {
        event.preventDefault();
        // Create a new div element
        TextAreacreate('.howto',"textarea");
            // Append the new div to the dynamic inputs container
    });

    document.getElementById("Save").addEventListener("click", function (event) {
        event.preventDefault();
        let formData = new FormData();
        let jsonData = {
            companyname: document.getElementById("comp_name").value,
            munadd: document.getElementById('Municipality').value,
            provadd: document.getElementById('province').value, 
            jobtitle: document.getElementById("Job_tt").value,
            jobtype: document.getElementById("jobtype").value,
            jobsummary: document.getElementById("job_sm").value,
            keyresponsibility: fetchevery(".resList"),
            educlevel: document.getElementById("educlevel").value,
            workingexp: document.getElementById("expnum").value,
            otherequirement:  fetchevery(".educ"),
            skillandcomp: fetchevery(".skilldiv"),
            workingcondition: fetchevery(".workondiv"),
            salary: document.getElementById("salary").value,
            compensation:  fetchevery(".comben"),
            hotoapply: fetchevery(".howto")
        };
         console.log(jsonData);
         console.log(formData);

        formData.append('jsonData', JSON.stringify(jsonData));
        
        fetch('../php/recruitmentform.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            prompt.textContent = 'Data submitted successfully!';
            popupBox.style.display = "block";
        })
        
        .catch(error => {
            prompt.textContent = "An error occurred: " + error.message;
            prompt.style.color = "red";
            });
            console.log('end line');
        
        document.getElementById('Fill_out').reset();
        window.location.href="../html/recruiter_dashboard.html";

    });

})
