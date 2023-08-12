<?php
@include 'functions.php';

session_start();

if (isset($_POST['submit'])) {
    $conn = connectDatabase();
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $select = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Compare the entered password with the stored password
        if ($password === $row['password']) {
            // Password is correct, set session variables
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: index.php"); // Redirect to the dashboard page
            exit();
        } else {
            $error[] = 'Incorrect password.';
        }
    } else {
        $error[] = 'User not found.';
    }

    mysqli_close($conn);
}
?>
