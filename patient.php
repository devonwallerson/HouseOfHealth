<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8"/>
        <meta name="viewport" content="width=device-width">
        <title>House of Health</title>
        <link rel = "stylesheet" href = "database2.css" />
        <script src = "script.js"></script>
        <header><h1>Patient Database</h1></header><br>
    </head>

    <body>
        <div class = "table">
        <table>
            <thead>
                <th>Patient First Name </th>
                <th>Patient Last Name </th>
                <th>Patient ID </th>
                <th>Receptionist ID</th>

            </thead>
            <tbody> 
            <?php
                include "connection.php";

                $result = mysqli_query($con, "SELECT * FROM patient");
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<td>" . $row['firstName'] . "</td>";
                    echo "<td>" . $row['lastName'] . "</td>";
                    echo "<td>" . $row['patientID'] . "</td>";
                    echo "<td>" . $row['receptionistID'] . "</td><tr>";
                    echo "\n";
                }
            ?>

            </tbody>
        </table>
        </div>
    
    <footer>
        <button id = "homeButton" onclick = "redirect()">Home Button</button>;
    </footer>
    <script>
        function redirect() {
            // Redirect to the Doctors Receptionist Database page
            window.location.href = "databasemain.html";
        }
    </script>
    </body>
</html>