document.addEventListener('DOMContentLoaded', function() {
    fetch('/php/welcome.php')
    .then(response => response.json())
    .then(data => {
        let dispUsername = document.getElementsByClassName('disp_username')[0];
        if (dispUsername) {
            dispUsername.textContent = "Welcome " + data.FirstName + data.message;
            console.log( "Welcome " + data.FirstName + data.message);
        }else{
            console.log("doesn't exist");
        }
        console.log(data.FirstName);
        console.log(data.message);
        console.log('DOM fully loaded and parsed');
    })
    .catch(error => console.error('Error fetching data:', error));
});
