<?php

@include 'functions.php';

session_start();

if (isset($_POST['submit'])) {
    $conn = connectDatabase();
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);

    $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            header('location:index.php');
        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            header('location:index.php');
        }
    } else {
        $error[] = 'Incorrect email or password!';
    }
}


$errors = [];

if (isset($_POST['submit'])) {
    $formData = [
        'email' => $_POST['email'],
        'password' => $_POST['password'],
    ];

    $validationRules = [
        'email' => ['required', 'email', 'sanitize'],
        'password' => ['required', 'sanitize'],
    ];

    if (validateForm($formData, $validationRules)) {
        // Your existing logic for database validation
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login form</title>
    <style>
        /* Style for the form container */

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;

        }

        .form {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            filter: blur(5px);
            z-index: -1;
            background-image: url(hb8.jpg);

        }

        .form-container {

            display: flex;
            width: 300px;
            margin: 0 auto;
            margin-top: 10%;
            padding: 20px;
            padding-bottom: 60px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        /* Style for the form header */
        .form-container h3 {
            text-align: center;
            margin-bottom: 15px;
            color: #333;
        }

        /* Style for error messages */
        .error-msg {
            text-align: center;
            display: block;
            color: red;
            margin-bottom: 10px;
        }

        /* Style for input fields */
        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-right: 10px;
            margin-bottom: 15px;

            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Style for submit button */
        .form-btn {
            display: block;
            width: 100%;
            padding: 10px;
            color: #fff;
            background-color: blue;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        /* Style for registration link */
        .form-container p {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .form-container a {
            color: #333;
            text-decoration: underline;
        }
    </style>

</head>

<body>
    <div class="form"></div>

    <div class="form-container">
        <form action="" method="post">
            <h3>Login now</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $errorMsg) {
                    echo '<span class="error-msg">' . $errorMsg . '</span>';
                }
                ;
            }
            ;
            ?>
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="submit" name="submit" value="Login now" class="form-btn">
        </form>
    </div>

</body>

</html>