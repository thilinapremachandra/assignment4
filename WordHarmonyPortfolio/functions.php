<?php

//Establish a database connection and return the connection object
function connectDatabase()
{
    $host = "localhost";
    $dbName = "id21137534_myportfoliodb";
    $user = "id21137534_thilina";
    $password = "Thilina@#22";

    $conn = new mysqli($host, $user, $password, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function insertContact($name, $subject, $phone, $email, $message)
{
    $conn = connectDatabase();

    $query = "INSERT INTO contact (name, subject, phone, email, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $subject, $phone, $email, $message);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return true; // Successful insertion
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return false; // Error inserting data
    }
}
function processFormData($tableName, $columns) {
    $formData = array();

    foreach ($columns as $column) {
        if (isset($_POST[$column])) {
            $formData[$column] = $_POST[$column];
        } else {
            $formData[$column] = '';
        }
    }

    $conn = connectDatabase();

    // Sanitize input data to prevent SQL injection
    foreach ($formData as $column => $value) {
        $formData[$column] = $conn->real_escape_string($value);
    }

    $columnsList = implode(', ', array_keys($formData));
    $valuesList = "'" . implode("', '", $formData) . "'";

    // Insert data into database
    $sql = "INSERT INTO $tableName ($columnsList) VALUES ($valuesList)";

    if ($conn->query($sql) === TRUE) {
        $resultMessage = "Form submitted successfully!";
    } else {
        $resultMessage = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    if ($resultMessage === "Form submitted successfully!") {
        echo "<script>alert('Form submitted successfully!'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('$resultMessage');</script>";
    }
}


function contactprocessForm() {
    if (isset($_POST['submit'])) {
        $tableName = "contact";
        $columns = array(
            'name', 'subject', 'phone', 'email', 'message'
        );
        processFormData($tableName, $columns);
    }
}


// In your functions.php file

$errors = [];

function validateForm($formData, $validationRules) {
    global $errors;

    foreach ($validationRules as $field => $rules) {
        foreach ($rules as $rule) {
            switch ($rule) {
                case 'required':
                    if (empty($formData[$field])) {
                        $errors[$field] = ucfirst($field) . " is required.";
                    }
                    break;
                case 'email':
                    if (!filter_var($formData[$field], FILTER_VALIDATE_EMAIL)) {
                        $errors[$field] = "Invalid email format.";
                    }
                    break;
                case 'lettersOnly':
                    if (!preg_match("/^[a-zA-Z ]*$/", $formData[$field])) {
                        $errors[$field] = "Only letters and spaces are allowed in " . ucfirst($field) . ".";
                    }
                    break;
                case 'sanitize':
                    $formData[$field] = sanitizeInput($formData[$field]);
                    break;
                // Add more cases for other validation rules as needed
            }
        }
    }

    return empty($errors);
}

function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

?>