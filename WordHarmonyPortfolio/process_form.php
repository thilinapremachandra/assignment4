<?php 
@include 'functions.php';
$conn = connectDatabase();
// Get form data
$name = $_POST['name'];
$subject = $_POST['subject'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];

// Prepare and execute SQL query to insert data into the contact table
$query = "INSERT INTO contact (name, subject, phone, email, message) VALUES ('$name', '$subject', '$phone', '$email', '$message')";

if (mysqli_query($conn, $query)) {
    echo "Data inserted successfully.";
} else {
    echo "Error inserting data: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>