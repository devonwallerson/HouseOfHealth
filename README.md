# HouseOfHealth
[Website Link](https://web.njit.edu/~dlw27/semesterProject/main.html) 

This is a semester-long full stack web application project for my IT202 (Internet Applications) course that will call for the use of HTML, CSS, JavaScript, and later on a backend. Currently, I am on part 2/5 of the project, where we have built the framework of the website using HTML and CSS and implemented some rules using JavaScript. Thank you for viewing!

Part 1 - 
During part one of the project, I created a web interface for a local doctor's office called the House of Health. It gives the receptionist access to patient accounts where they can search for their account, book an appointment, cancel an appointment, request procedures, cancel procuedures, update patient information, or create a new patient account. Using HTML, I created four text fields for name, phone number, and a password. I also used a numeric field for the receptionist's ID, and a checkbox to indicate whether email confirmation for the patient is necessary. This comes into use later in the project. Additionally, I used a drop down menu to indicate what type of transaction is being performed.
Each element follows HTML protocol an dhas its own name and id attribute. 

Note - Part 1 has a side project recreate the drop down with radio buttons and drop down boxes as additional main files. 

Part 2 - 
This section of the project focueses on implementing the JavaScript portion of the project. We use JavaScript to validate the receptionist's data and verifies the receptionist's name, password, ID, and email (if conformation is requested). I also ensured that the text inserted to the fields follow protocol (for example, phone numbers being 10 digits long and delimited by ( - ). I was able to implement this through two functions : validateForm and verifyReceptionist. validateForm takes in all of the inputs and establishes the patterns that must be followed in the input fields. Then, it is checked for errors against those patterns. If it passes, it runs the verifyReceptionist function, which returns a boolean that checks the data inputted against an array of saved data. This way, we can see if the data inputted is valid but not found in the registry, and therefore invalid. 

Check website against these Values
Devon Wallerson, password D(*)dog2234, id 1231, email devonwallerson@gmail.com
Clifford Prince, password C(*)prince200, id 7447, email: n/a (leave blank on form) 

Replace parenthesis with asterisk**
