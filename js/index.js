const combobox = document.getElementById('combobox');
const dropdownButton = document.getElementById('dropdownButton');
const suggestionsContainer = document.getElementById('suggestions');
const seacrbutton = document.getElementById('srxtext');

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

const suggestions = [
    'Claveria', 'Laguindingan', 'Villanueva', 'Tagoloan',
    'Sugbongcogon', 'Talisayan', 'Alubijid', 'Balingasag', 
    'Balingoan', 'Binuangan', 'Gitagum', 'Initao', 'Jasaan',
    'Kinoguitan', 'Lagonglong',' Libertad', 'Lugait', 'Magsaysay',
     'Manticao', 'Medina', 'Naawan', 'Opol', 'Talisayan', 'Salay'
    ];

seacrbutton.addEventListener('click', ()=>{
    let searchedItem = document.getElementById('srx_box').value;
    console.log(searchedItem);
    let formData = new FormData();
    formData.append('Searched', searchedItem);
    fetch('../php/getsearch.php',{
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        let count = 0
        const resultscont = document.getElementById('srxResult');
        resultscont.innerHTML = '';
        data.jbtitles.forEach(works => {
                let button1 = document.createElement('button');
                    button1.id = data.Jobtitlecode[count];
                    console.log(data.Jobtitlecode[count]);
                    button1.onclick = function() {
                        kickedbutton(this);
                    };
                    button1.innerText = works;
                    resultscont.appendChild(button1);            
        count++;    
            
        });

        
    })
    .catch(error => {
      console.log("An error occurred: " + error.message);
    });

    let kickedcount = 0;
    function kickedbutton(button) {
        const button1 = button.id;
        console.log(button1);
        kickedcount = 0;
        formData.append("jobtitlecode", button1);
        fetch('../php/recruitmentDetails.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href="../html/recruitment_details.php";
            } else {
                prompt.textContent = "Internal Error";
            }
        })
        
    }

});

window.addEventListener('DOMContentLoaded', loadDynamicContent);
