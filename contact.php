<?php
// Database connection details
$servername = "localhost";  // Change this if needed
$username = "root";         // Change this if needed
$password = "";             // Change this if needed
$database = "DreamSpot";    // Ensure this matches your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validate inputs
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "Message sent successfully!";
        } else {
            echo "Error occurred! Try again.";
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}

// Close the database connection
$conn->close();
?>

