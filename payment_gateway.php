<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travels";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$upi_id = $_POST['upi_id'];
$payment_method = $_POST['payment_method'];
$amount = 100.00; // Set dynamically if required

// Insert data into database
$sql = "INSERT INTO transactions (user_id, payment_method, upi_id, amount, status)
        VALUES ('user123', '$payment_method', '$upi_id', $amount, 'Pending')";

if ($conn->query($sql) === TRUE) {
    echo "Payment initiated successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
