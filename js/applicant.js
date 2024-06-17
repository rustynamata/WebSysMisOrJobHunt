document.addEventListener("DOMContentLoaded", ()=> {

fetch('../php/getapplicantlist.php')
.then(response => response.json())
.then(data => {
    data.applicantsId.forEach(ids => {
        if(letus===0){
        let divobutton = document.querySelector('.'+button1);
        let applicantbutton = document.createElement('button');
        applicantbutton.id = ids;
        applicantbutton.onclick = function() {
            kickedbutton(this);
        };
        applicantbutton.innerText = data.applicantprimdet[count];
        divobutton.appendChild(applicantbutton);  
        count  += 1;}
    });
})
})