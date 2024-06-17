document.addEventListener("DOMContentLoaded", ()=> {
    const createopen = document.querySelector('.job_op');
    const listview = document.getElementById('listview');
    const thmbview = document.getElementById('thumbnailview');
    let BUTTONORIG = {};
    const buttonspardiv = document.querySelector('.list');
    const listdiv = document.querySelector('.list');
    let lista = {};
    lista.display = getComputedStyle(listdiv).display;
    lista.gridTemplateColumns = getComputedStyle(listdiv).gridTemplateColumns;
    lista.gridGap = getComputedStyle(listdiv).gap;

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
    loadDynamicContent();
    fetch('../php/recruitmentDashboard.php')
    .then(response => response.json())
    .then(data => {
        console.log(data);
        let count = 0
        data.jbtitles.forEach(titles => {
        const keyresdiv = document.querySelector('.list');
            let containelements = document.createElement('div');
                containelements.className = data.Jobtitlecode[count];
                let button1 = document.createElement('button');
                    button1.id = data.Jobtitlecode[count];
                    button1.onclick = function() {
                        kickedbutton(this);
                    };
                    button1.innerText = titles;
            containelements.appendChild(button1);            
        count  ++;    
        keyresdiv.appendChild(containelements);
            
        });

    });
    

    createopen.addEventListener('click', function (event) {
        event.preventDefault();
        // Create a new div element
        window.location.href="recruitment_form.html";
    }); 
    let letus = 0;
    listview.addEventListener('click', function (event) {
        event.preventDefault();
        letus = 0;
        // Create a new div element
        const buttons = document.querySelectorAll('.list button');
        buttons.forEach(button => {
            button.style.width = '70%';
            button.style.marginBottom = '10px';
        });
        const listdiv = document.querySelector('.list');
        listdiv.style.display = lista.display;
        listdiv.style.gridTemplateColumns = lista.gridTemplateColumns;
        listdiv.style.gridGap =lista.gridGap;
    }); 

    thmbview.addEventListener('click', function (event) {
        event.preventDefault();
        letus = 1;
        // Create a new div element
        const buttons = document.querySelectorAll('.list button');
        buttons.forEach(button => {
            button.style.width = '100%';
            button.style.height = '100%';
        });
        const listdiv = document.querySelector('.list');
        listdiv.style.display = 'grid';
        listdiv.style.gridTemplateColumns = '1fr 1fr 1fr 1fr';
        listdiv.style.gridGap ='10px 5px';
    }); 
    



    let kickedcount = 0;

    function kickedbutton(button) {
        let tb = document.querySelector('.applicantList');
        tb.style.display= 'block';
        const button1 = button.id;
        console.log(button1);
        let formData = new FormData();
        let count = 0;
        formData.append("jobtitlecode", button1);
    
        fetch('../php/getapplicantlist.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            
            if (data.applicantsId && data.applicantdet) {
                let table = document.querySelector('.applicants');
                data.applicantdet.forEach(FNLN => {
                    if(document.getElementById(FNLN[0])){

                    }else{
                        let tr = document.createElement('tr');
                        let td = document.createElement('td');
                        td.id = FNLN[0];
                        let name = FNLN[1]+" "+FNLN[2];
                        td.innerText = name; // Displaying notifier's first name as an example
                        tr.appendChild(td);
                        table.appendChild(tr);
                        count++;
                            }
                            
                });
    
                kickedcount++; // Increment the kickedcount
            } else {
                console.error('Invalid data structure received from the server');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
       
    document.querySelector('.applicants').addEventListener('click', function(e) {
        // Check if the clicked element is a table cell (TD)
        if (e.target && e.target.nodeName === 'TD') {
           let selected = e.target.id;
           let formData = new FormData();
           formData.append("id", selected);
           fetch('../php/setsession.php', {
            method: 'POST',
            body: formData
            })
            .then(response => response.json())
            .then(data => {
                
                window.location.href=" ../html/applicantprofile.php";
            })
        }
        });

})
