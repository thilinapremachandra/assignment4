<?php
$errors = array(); // Initialize an array to store error messages

if (isset($_POST['submit_form'])) {
    function validate_data($data) {
        $con = mysqli_connect('localhost', 'id21137534_thilina', 'Thilina@#22', 'id21137534_myportfoliodb');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }
        
        $data = trim($data);
        $data = stripslashes($data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        $data = mysqli_real_escape_string($con, $data);
        
        mysqli_close($con);
        return $data;
    }

    $name = validate_data($_POST['name']);
    $subject = validate_data($_POST['subject']);
    $phone = validate_data($_POST['phone']);
    $emailid = validate_data($_POST['email']);
    $message = validate_data($_POST['message']);

    // Validate name: Ensure it contains only letters and spaces
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $errors['name'] = "Name should contain only letters and spaces.";
    }

    // Validate email format
    if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    // Sanitize and validate other fields as needed

    if (empty($errors)) { // If no errors, proceed with insertion
        $con = mysqli_connect('localhost', 'id21137534_thilina', 'Thilina@#22', 'id21137534_myportfoliodb');
        if (!$con) {
            die('Could not connect: ' . mysqli_connect_error());
        }

        $insertdata = "INSERT INTO contact (name, subject, phone, email, message) VALUES ('$name','$subject','$phone','$emailid','$message')";
        
        if (mysqli_query($con, $insertdata)) {
            echo "Record added successfully.";
            header('location:index.php');
        } else {
            echo "Error: " . mysqli_error($con);
        }

        mysqli_close($con);
    }
}
?>