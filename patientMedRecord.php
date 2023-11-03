<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8"/>
        <meta name="viewport" content="width=device-width">
        <title>House of Health</title>
        <link rel = "stylesheet" href = "database2.css" />
        <script src = "script.js"></script>
        <header><h1>Patient Medical Record Database</h1></header><br>
    </head>

    <body>
        <div class = "table">
        <table>
            <thead>
                <th>Date of Birth</th>
                <th>Age</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Shots Given</th>
                <th>Illnesses</th>
                <th>Patient ID</th>

            </thead>
            <tbody> 
            <?php
                include "connection.php";

                $result = mysqli_query($con, "SELECT * FROM patientMedRecord");
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<td>" . $row['DOB'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['phoneNumber'] . "</td>";
                    echo "<td>" . $row['shotsGiven'] . "</td>";
                    echo "<td>" . $row['Illnesses'] . "</td>";
                    echo "<td>" . $row['patientID'] . "</td><tr>";
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