document.addEventListener("DOMContentLoaded", () => {
    const elementary = document.getElementById('idelem');
    const elementaryClass = document.querySelector('.classelem');
    const highCheckbox = document.getElementById('idhigh');
    const highClass = document.querySelector('.classhigh');
    const collegeCheckbox = document.getElementById('idcollege');
    const collegeClass = document.querySelector('.classcollege');
    const expaddClass = document.querySelector('.add_exp');
    const parClass = document.querySelector('.exps');
    const elementarybutton = document.getElementById('elembtn');
    const hsbutton = document.getElementById('highbtn');
    const colbtn = document.getElementById('colbtn');
    let elemcnt = 0;
    let hscnt = 0;
    let colcnt = 0;
    let poscnt = 0;
    var educattain = 0;
    let expintcnt = 0;
    let elemids = ['elemSN','elemSA', 'elemlvl','elemYR'];
    let hsids = ['hsSN','hsSA', 'hslvl','hsYR'];
    let colids = ['coldeg','colSN','colSA', 'collvl','colYR'];
    const elemlevels = [['Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6','Graduated'],
    ['1','2','3','4','5','6','Graduated']
    ];
    const hslevels = [['Grade 7','Grade 8','Grade 9','Grade 10','Completed','Grade 11','Grade 11','Graduated'],
    ['7','8','9','10','jh_complete','11','12','Sh_Graduated']
    ];
    const collevels = [['1st Year','2nd Year','3rd Year','4th Year','Colllege Graduate'],
    ['13','14','15','16','Colllege Graduate']
    ];

    function dynammicinput(refclass, ids, count, arrayset, idset) {
        let newdiv = document.createElement("div");
        let idsetl = idset.length;
        for (let i = 0; i < idsetl; i++) {
            if(i === idsetl - 2) {
                let newselect = document.createElement("select");
                newselect.id = `${idset[i]}${count}`;
                for (let e = 0; e < arrayset[0].length; e++) {
                    newselect.add(new Option(arrayset[0][e], arrayset[1][e]));
                }
                newdiv.appendChild(newselect);
            } else {
                let newInput = document.createElement("input");
                newInput.type = "text";
                newInput.id = `${ids[i]}${count}`;
                newdiv.appendChild(newInput);
            }
        }

        refclass.appendChild(newdiv);
    }

    elementary.addEventListener('change', () => {
        if (elementary.checked) {
            elemcnt += 1;
            educattain = 1;
            elementaryClass.style.display = 'block';
        } else {
            elementaryClass.style.display = 'none';
            elemcnt -= 1;
        }
    });

    highCheckbox.addEventListener('change', () => {
        if (highCheckbox.checked) {
            hscnt += 1;
            educattain = 2;
            highClass.style.display = 'block';
        } else {
            highClass.style.display = 'none';
            hscnt -= 1;
        }
    });

    collegeCheckbox.addEventListener('change', () => {
        if (collegeCheckbox.checked) {
            colcnt += 1;
            educattain = 3;
            collegeClass.style.display = 'block';
        } else {
            collegeClass.style.display = 'none';
            colcnt -= 1;
        }
    });


    colbtn.addEventListener('click', function (event) {
        event.preventDefault();
        colcnt += 1;
        dynammicinput(collegeClass, colids, colcnt, collevels, colids);
    });

    expaddClass.addEventListener('click', function (event) {
        event.preventDefault();
        expintcnt += 1;
        let newposdiv = document.createElement("div");
        newposdiv.class = `exp${poscnt+=1}`;
        for (let i = 0; i < 2; i++) {
            let newInputpos = document.createElement("input");
            newInputpos.type = "text";
            newInputpos.id = `expinput${expintcnt}`;
            newposdiv.appendChild(newInputpos);
        }
        let newtxtareapos = document.createElement("textarea");
        newtxtareapos.id = `exptxtarea${expintcnt}`;
        newposdiv.appendChild(newtxtareapos);
        parClass.appendChild(newposdiv);
    });

    var popupBox = document.getElementById("popupBox");
    var closeBtn = document.querySelector(".close");


    document.getElementById("Submit").addEventListener("click", function (event) {
        event.preventDefault();
        let prompt = document.querySelector(".prompt");
        let formData = new FormData();
        let jsonData = {
            firstName: document.getElementById("Fname").value,
            lastName: document.getElementById("Lname").value,
            midname: document.getElementById("Mname").value,
            sex: document.getElementById("sex").value,
            age: document.getElementById("age").value,
            birthdate: document.getElementById("bdate").value,
            address: document.getElementById("address").value,
            civilStatus: document.getElementById("civil").value,
            nationality: document.getElementById("nationality").value,
            phone: document.getElementById("phone").value,
            email: document.getElementById("email").value,
            messengerLink: document.getElementById("messenger_link").value,
            elemdata: [],
            hsdata: [],
            coldata: []
        };
        console.log(jsonData);

        function compiledata(ids, count, dict) {
            for (let i = 1; i <= count; i++) {
                let detail = {};
                ids.forEach(id => {
                    let element = document.getElementById(`${id}`);
                    if (element) {                        
                            detail[id] = element.value;
                        
                    }
                });
                dict.push(detail);
            }
        }

        compiledata(elemids, elemcnt, jsonData.elemdata);
        compiledata(hsids, hscnt, jsonData.hsdata);
        compiledata(colids, colcnt, jsonData.coldata);

        console.log(jsonData);
        
        formData.append('jsonData', JSON.stringify(jsonData));

        fetch('../php/applicationform.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.status==='error'){
                prompt.textContent = 'Account Creation Failed: !';
            }else{
            console.log('Success:', data);
            prompt.textContent = 'Data submitted successfully!';
            popupBox.style.display = "block";
            }
        })
        .catch(error => {
            prompt.textContent = "An error occurred: " + error.message;
            prompt.style.color = "red";
            });
            console.log('end line');
    });

    closeBtn.onclick = function(event) {
        event.preventDefault();
        var form = document.getElementById('Fill_out');
            
        // Iterate over all input and textarea elements and reset their values
        form.querySelectorAll('input, textarea').forEach(function(element) {
            if (element.type === 'checkbox') {
                element.checked = false; // Uncheck checkboxes
            } else {
                element.value = ''; // Reset value for other input types and textareas
            }
        });
        window.location.href = "index.html";
        popupBox.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == popupBox) {
            popupBox.style.display = "none";
        }
    }

    async function loadDynamicContent() {
        try {
            const response = await fetch('../html/header.php');
            if (response.ok) {
                const content = await response.text();
                document.getElementById('header').innerHTML = content;

                // Re-attach event listeners and execute scripts
                evalScripts(content);
            } else {
                console.error('Failed to fetch content');
            }
        } catch (error) {
            console.error('Error fetching content:', error);
        }
    }

    // Function to evaluate and execute scripts within fetched content
    function evalScripts(content) {
        const scriptMatches = content.match(/<script>([\s\S]*?)<\/script>/g) || [];
        scriptMatches.forEach(scriptTag => {
            const scriptContent = scriptTag.match(/<script>([\s\S]*?)<\/script>/)[1];
            const scriptElement = document.createElement('script');
            scriptElement.textContent = scriptContent;
            document.body.appendChild(scriptElement).parentNode.removeChild(scriptElement);
        });
    }
});
