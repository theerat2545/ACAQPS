<?php
include '../config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Fetch user data from the database based on $userId
    $sql = "SELECT * FROM `tb_user` WHERE `user_id` = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();

        // Return user data as JSON
        echo json_encode($userData);
    } else {
        // User not found
        http_response_code(404);
    }
} else {
    // Invalid request
    http_response_code(400);
}

// Close the database connection
$conn->close();
