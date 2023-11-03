<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset = "UTF-8"/>
        <meta name="viewport" content="width=device-width">
        <title>House of Health</title>
        <link rel = "stylesheet" href = "database2.css" />
        <header><h1>Receptionist Database</h1></header><br>
    </head>

    <body>
        <div class = "table">
        <table>
            <thead>
                <th>Receptionist First Name </th>
                <th>Receptionist Last Name </th>
                <th>Receptionist Password </th>
                <th>Receptionist ID Number </th>
                <th>Receptionist Phone Number </th>
                <th>Receptionst Email</th>
            </thead>
            <tbody> 
            <?php
                include "connection.php";

                $result = mysqli_query($con, "SELECT * FROM receptionist");
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<td>" . $row['firstName'] . "</td>";
                    echo "<td>" . $row['lastName'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['phoneNumber'] . "</td>";
                    echo "<td>" . $row['emailAddress'] . "</td><tr>";
                    echo "\n";
                }
            ?>

            </tbody>
        </table>
        </div>
    <script>
        function redirect() {
            // Redirect to the Doctors Receptionist Database page
            window.location.href = "databasemain.html";
        }
    </script>
    <footer>
        <button id = "homeButton" onclick = "redirect()">Home Button</button>;
    </footer>
    
    </body>
</html>