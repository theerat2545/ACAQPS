<?php
include '../config.php';

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editUserid'])) {
    $user_id = $_POST['editUserid'];
    $editPrefix = $_POST['editPrefix'];
    $editFirstname = $_POST['editFirstname'];
    $editLastname = $_POST['editLastname'];

    // Assuming you want to update user_prefix, user_firstname, and user_lastname columns
    $sql = "UPDATE tb_user SET user_prefix = '$editPrefix', user_firstname = '$editFirstname', user_lastname = '$editLastname' WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo json_encode(["status" => "success"]);
        echo "<script>window.location.href = '../master/table_users.php';</script>";
        exit;
    } else {
        echo json_encode(["status" => "error"]);
    }
} else {
    http_response_code(400);
}

$conn->close();
?>
