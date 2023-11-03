
var receptionistButton = document.getElementById("receptionistDatabase");
var patientButton = document.getElementById("patientDatabase");
var patientAppts = document.getElementById("patientAppts");
var patientMedRecord = document.getElementById("patientMedRecord");

receptionistButton.addEventListener("mouseover",function(){
    receptionistButton.style.backgroundColor = "black";
});

receptionistButton.addEventListener("mouseout",function(){
    receptionistButton.style.backgroundColor = "#007BFF";
});

receptionistButton.addEventListener("click",function(){
    window.location.href = "receptionist.php";
});


patientButton.addEventListener("mouseover",function(){
    patientButton.style.backgroundColor = "black";
});

patientButton.addEventListener("mouseout",function(){
    patientButton.style.backgroundColor = "#007BFF";
});

patientButton.addEventListener("click",function(){
    window.location.href = "patient.php";
});

patientAppts.addEventListener("mouseover",function(){
    patientAppts.style.backgroundColor = "black";
});

patientAppts.addEventListener("mouseout",function(){
    patientAppts.style.backgroundColor = "#007BFF";
});

patientAppts.addEventListener("click",function(){
    window.location.href = "patientAppts.php";
});

patientMedRecord.addEventListener("mouseover",function(){
    patientMedRecord.style.backgroundColor = "black";
});

patientMedRecord.addEventListener("mouseout",function(){
    patientMedRecord.style.backgroundColor = "#007BFF";
});

patientMedRecord.addEventListener("click",function(){
    window.location.href = "patientMedRecord.php";
});




// Sample Receptionists (With and without checked email) using an array.

const validatedReceptionists =  [
    {firstName : "Devon", lastName : "Wallerson" , password : "D*dog2234", id:"1231", email:"devonwallerson@gmail.com"},
    {firstName : "Clifford", lastName : "Prince", password : "C*prince2000", id : "7447" , email : ""},
    {firstName: "Alice", lastName: "Johnson", password: "A*johnson123", id: "9876", email: "alice.j@example.com"},
    {firstName: "Bob", lastName: "Smith", password: "B*smith456", id: "3456", email: "bob.smith@mail.com"},
    {firstName: "Ella", lastName: "Davis", password: "E*davis789", id: "2345", email: "ella.d@icloud.org"},
    {firstName: "George", lastName: "Brown", password: "G*brown000", id: "6543", email: "george.b@outlook.com"},
    {firstName: "Hannah", lastName: "Williams", password: "H*williams111", id: "5555", email: "hannah.w@yahoo.com"},
    {firstName: "Jack", lastName: "Johnson", password: "J*johnson234", id: "1111", email: "jack.j@njit.edu"},
    {firstName: "Olivia", lastName: "Miller", password: "O*miller999", id: "2222", email: "olivia.m@njit.edu"},
    {firstName: "William", lastName: "Davis", password: "W*davis789", id: "7890", email: "william.d@example.com"},
    {firstName: "Sophia", lastName: "Wilson", password: "S*wilson456", id: "1010", email: "sophia.w@outlook.com"}
];

function checkbox(){
    document.getElementById("emailReq").classList.toggle("show");
}

document.getElementById("emailConformation").addEventListener("click",checkbox);

function validateForm(){
    // Instantializing all the variables for the function to work.
    let firstName = document.getElementById("firstNameInput").value;
    let lastName = document.getElementById("lastNameInput").value;
    let password = document.getElementById("passwordInput").value;
    let id = document.getElementById("IDNumber").value;
    let phoneNumber = document.getElementById("phoneNumber").value;
    let email = document.getElementById("receptionistEmail").value;
    if (email == ''){
        email = null;
    }
    let emailConfirmation = document.getElementById("emailConformation").value;
    let transaction = document.getElementById("dropDown").value;

    // Establishing the patterns that the inputs have to follow
    const passwordPattern = /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\])(?=.*\d).{1,16}$/; // fufills password concerns 
    const idPattern = /^[0-9]{4}$/; // 4 digit values between 0-9
    const phonePattern = /^(?=(?:\D*\d){10}\D*$)[\d]+([- ][\d]+)*$/; // 10 digit values between 0-9
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{3,5}$/;
    // email pattern, uppercase/lowercase followed by @ then another set of username 
    // then ., and so on


    // Validation
    if (firstName === ""){
        alert("Enter First Name");
        document.getElementById("firstNameInput").focus();
        return;
    } else if(lastName === "") {
        alert("Enter Last Name");
        document.getElementById("lastNameInput").focus();
        return;
    } else if (!password.match(passwordPattern)) {
        alert("Invalid Password. The user password should contain a max of 16 characters and have at least 1 uppercase letter, one special character and one numeric character");
        document.getElementById("passwordInput").focus();
        return;
    } else if (!id.match(idPattern)){ // If ID Does not match the idPattern
        alert("Invalid ID. Use a four digit number.");
        document.getElementById("IDNumber").focus();
        return;
    } else if (!phoneNumber.match(phonePattern)) { // If Phone NUmber does not match the phone Pattern
        alert("Invalid Phone Number. The user phone number should consist of 10 digits which can be delineated either by spaces or dashes")
        document.getElementById("phoneNumber").focus();
        return;
    } else if (email && !email.match(emailPattern)) {
        alert("Invalid Email Address. The email address must contain an @ followed by a period and an email domain that consists of 3 to 5 character");
        document.getElementById("receptionistEmail").focus();
        return;
    }

    const validity = verifyReceptionist(firstName, lastName, password, id, email, emailConfirmation);
        if (validity === true){
            alert("Welcome, " + firstName + ' ' + lastName + " ! You have entered the system for " + transaction);
        } else {
            alert("Receptionist with these credentials can not be found.")
        }
    }



    function verifyReceptionist(firstName, lastName, password, id, email, emailConfirmation) {
        for (const receptionist of validatedReceptionists) {
            if (
                receptionist.firstName === firstName &&
                receptionist.lastName === lastName &&
                receptionist.password === password &&
                receptionist.id === id
            ) {
                if (emailConfirmation) {
                    if (email === receptionist.email) {
                        return true;
                    }
                } else {
                    return true;
                }
            }
        }
        return false; // Not found
    }
    

const submitButton = document.getElementById("submitButton");
submitButton.addEventListener("click", function(){
    validateForm();
});