<?php
include '../config.php';


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sub_id'])) {
    $subid = $_POST['sub_id'];
    $examid = $_POST['examid'];
    $subname = $_POST['subname'];

    // Assuming you want to update user_prefix, user_firstname, and user_lastname columns
    $sql = "UPDATE tb_subject SET SubjectID = '$examid', SubjectName = '$subname' WHERE sub_id = '$subid'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo json_encode(["status" => "success"]);
        echo "<script>window.location.href = '../master/table_subject.php';</script>";
        exit;
    } else {
        echo json_encode(["status" => "error"]);
    }
} else {
    http_response_code(400);
}

// Close the database connection
$conn->close();

?>