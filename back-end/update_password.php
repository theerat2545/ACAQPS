<?php
include '../config.php';
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted data
    $userId = $_POST['userid'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the data (you might want to perform more validation here)
    if (empty($userId) || empty($username) || empty($password)) {
        // Handle empty fields
        echo "Please fill in all fields.";
        exit;
    }

    // Here you might want to perform additional validation, such as checking if the user exists in the database, etc.

    // Hash the password (you should use password_hash() for security)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Assuming you have a database connection, update the user's password
    // Example code using PDO:
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=your_database", "username", "password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");

        // Bind parameters
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $userId);

        // Execute the statement
        $stmt->execute();

        // Password updated successfully
        echo "Password updated successfully!";
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // If the request method is not POST, redirect the user or display an error message
    echo "Invalid request method.";
}
?>
