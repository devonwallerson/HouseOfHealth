</html>
<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include("connection.php");
    $_SESSION['receptionistID'] = $_POST['receptionistID'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $receptionistFirstName = $_POST["receptionistFirstName"];
        $receptionistLastName = $_POST["receptionistLastName"];
        $password = $_POST["password"];
        $receptionistID = $_POST["receptionistID"];
        $receptionistPhone = $_POST["receptionistPhone"];
        $receptionistEmailConformation = isset($_POST["receptionistEmailConformation"]);

        if ((($_POST["receptionistEmailConformation"]) == true)){
            $receptionistEmail = $_POST["receptionistEmail"];
        } else {
            $receptionistEmail = null;
        }

        $dropDown = $_POST["dropDown"];

        // Querying the database for authentication

        if ($receptionistEmail != null || $receptionistEmailConformation == true){
            $query = "SELECT * FROM receptionist WHERE firstName = ? AND lastName = ? AND password = ? AND id = ? AND phoneNumber = ? AND emailAddress = ?";
            // to prevent SQL injection
            $stmt = $con->prepare($query);
            $stmt->bind_param("ssssss", $receptionistFirstName, $receptionistLastName, $password, $receptionistID, $receptionistPhone, $receptionistEmail); // ssss because they're all strings
            $stmt->execute();

            $stmt->bind_result($dbreceptionistFirstName, $dbreceptionistLastName, $dbpassword, $dbreceptionistID, $dbreceptionistPhone, $dbreceptionistEmail); // Update with your actual column names
            $stmt->fetch();
        } else {
            $query = "SELECT firstName, lastName, password, id, phoneNumber FROM receptionist WHERE firstName = ? AND lastName = ? AND password = ? AND id = ? AND phoneNumber = ?";
            // to prevent SQL injection
            $stmt = $con->prepare($query);
            $stmt->bind_param("sssss", $receptionistFirstName, $receptionistLastName, $password, $receptionistID, $receptionistPhone); // ssss because they're all strings
            $stmt->execute();

            $stmt->bind_result($dbreceptionistFirstName, $dbreceptionistLastName, $dbpassword, $dbreceptionistID, $dbreceptionistPhone); // Update with your actual column names
            $stmt->fetch();
        }
        

        if ($dbreceptionistFirstName !== null) {
            $_SESSION['receptionistID'] = $dbreceptionistID; // session variable to send over names
            switch ($dropDown){
                case 'searchreceptionist':
                    header('Location:searchReceptionist.php');  
                    break;
                
                case 'updatePatientInfo':
                    header('Location:updateInfo.php');             
                    break;

                case 'scheduleAppt':
                    header('Location:verifyPatient.php');             
                    break;

                case 'cancelAppt':
                    header('Location:cancelAppt.php');             
                    break;

                case 'scheduleProcedure':
                    header('Location:scheduleProcedure.php');             
                    break;

                case 'cancelProcedures':
                    header('Location:cancelProcedure.php');             
                    break;

                case 'createNewPatient':
                    header('Location:createNewPatient.php');             
                    break;

                case 'accessMainDatabase':
                    header('Location:databasemain.html');
                    break;

                default:
                    header('Location:main.html');             
                    break;
            }
        } else {
            header('Location:main.html');
            echo json_encode(["success" => false, "error" => 1]);
        }

        $stmt->close();
    }

    $con->close();
?>
