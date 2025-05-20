<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travels";

// Create a new MySQLi instance
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the registration form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];
   // $email = $_POST["email"];
    // $number = $_POST["Number"];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO login (username,password) VALUES (?,?)");

    // Bind parameters and execute the statement
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        // Registration completed
        echo "Login Sucessfull!";

        // Redirect to login page after a delay
        // header("refresh:3; url=login.php");
        exit;
    } else {
        // An error occurred while storing credentials
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>