<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
            width: 100%;
            overflow-x: hidden;
            background-color: rgb(244, 215, 161);
        }

        #notification, #inputTableContainer {
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        @media (max-width: 600px) {
            th, td {
                padding: 10px;
            }

            #notification, #inputTableContainer {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div id="notification">
        <table id="notiftb">
            <tr><th>Notifications</th></tr>
        </table>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let count = 0;
            fetch('../php/notiffetch.php')
            .then(response => response.json())
            .then(data => {
                let table = document.getElementById('notiftb');
                let count = 0;

                data.dataset.forEach(notification => {
                    let tr = document.createElement('tr');
                    let td = document.createElement('td');
                    td.id = notification.notifierID;

                    if (!notification.status) {
                        td.style.backgroundColor = "gray";
                    }
                    td.innerText = notification.notification; // Displaying notifier's first name as an example

                    tr.appendChild(td);
                    table.appendChild(tr);
                    count++;
                });
            });


            document.getElementById('notiftb').addEventListener('click', function(e) {
                // Check if the clicked element is a table cell (TD)
                if (e.target && e.target.nodeName === 'TD') {
                   let selected = e.target.id;
                   console.log(selected)
                   
                }
            });
        });
    </script>
</body>
</html>                 