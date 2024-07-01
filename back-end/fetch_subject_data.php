<?php
include '../config.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subjectId'])) {
    $subjectId = $_POST['subjectId'];

    // Fetch user data from the database based on $userId
    $sql = "SELECT * FROM `tb_subject` WHERE `sub_id` = '$subjectId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $subjectData = $result->fetch_assoc();

        // Return user data as JSON
        echo json_encode($subjectData);
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
?>
