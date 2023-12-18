<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8"/>
        <meta name="viewport" content="width=device-width">
        <title>House of Health</title>
        <link rel = "stylesheet" href = "database2.css" />
        <script src = "script2.js"></script>
        <header><h1>Patient Appointment Database</h1></header><br>
    </head>

    <body>
        <div class = "table">
        <table>
            <thead>
                <th>Appointment Date</th>
                <th>Appointment Type</th>
                <th>Procedure Date</th>
                <th>Procedure Type</th>
                <th>Physician Name</th>
                <th>Patient ID</th>

            </thead>
            <tbody> 
            <?php
                include "connection.php";

                $result = mysqli_query($con, "SELECT * FROM patientAppts");
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<td>" . $row['appointmentDate'] . "</td>";
                    echo "<td>" . $row['appointmentType'] . "</td>";
                    echo "<td>" . $row['procedureDate'] . "</td>";
                    echo "<td>" . $row['procedureType'] . "</td>";
                    echo "<td>" . $row['physicianName'] . "</td>";
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