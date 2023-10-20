// Sample Receptionists (With and without checked email) using an array.

const validatedReceptionists =  [
    {firstName : "Devon", lastName : "Wallerson" , password : "D*dog2234", id:"1231", email:"devonwallerson@gmail.com"},
    {firstName : "Clifford", lastName : "Prince", password : "C*prince2000", id : "7447" , email : null}
];

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
    const passwordPattern = /^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\])(?=.*[0-9]).{8,16}$/; // fufills password concerns 
    const idPattern = /^[0-9]{4}$/; // 4 digit values between 0-9
    const phonePattern = /^(?=(?:\D*\d){10}\D*$)[\d\- ]+$/; // 10 digit values between 0-9
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // email pattern, uppercase/lowercase followed by @ then another set of username 
    // then ., and so on


    // Validation
    if (!password.match(passwordPattern)) {
        alert("Invalid Password. Follow password protocol");
        document.getElementById("passwordInput").focus();
        return;
    } else if (!id.match(idPattern)){ // If ID Does not match the idPattern
        alert("Invalid ID. Use a four digit number.");
        document.getElementById("IDNumber").focus();
        return;
    } else if (!phoneNumber.match(phonePattern)) { // If Phone NUmber does not match the phone Pattern
        alert("Invalid Phone Number. Please use a valid phone number with 10 digits.")
        document.getElementById("phoneNumber").focus();
        return;
    } else if (email != null && !email.match(emailPattern)) { // if Email is not equal to null, or does not match the email Pattern
        alert("Invalid Email Address. Please use proper Email Protocol");
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
                receptionist.id === id &&
                (emailConfirmation ? receptionist.email === email : email === null)
            ) {
                return true; // Receptionist Found.
            }
        }
        return false; // Not found
    }
    

const submitButton = document.getElementById("submitButton");
submitButton.addEventListener("click", function(){
    validateForm();
});
