<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

<?php
include_once '../config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $SubjectID = mysqli_real_escape_string($conn, $_POST['SubjectID']);
    $SubjectName = mysqli_real_escape_string($conn, $_POST['SubjectName']);

    $counter = 1;
    $max = 999;
    for ($i = 0; $i < $max; $i++) {
        $id = sprintf("s%03u", $counter);
        $sql = "SELECT * FROM `tb_subject` WHERE sub_id = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $counter++;
            continue;
        }
        break;
    }

    $sql = "INSERT INTO tb_subject (sub_id, SubjectID, SubjectName) VALUES ('$id', '$SubjectID', '$SubjectName')";

    if (mysqli_query($conn, $sql)) {
        redirectToAdminPage("Records added successfully.");
    } else {
        redirectToErrorPage("Error: " . mysqli_error($conn));
    }
}

mysqli_close($conn);

function redirectToAdminPage($message = null)
{
    $message = $message ? $message : "OK";
    echo "<script>
        Swal.fire({
            title: 'Success',
            text: '$message',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '../master/table_subject.php';
        });
    </script>";
    exit();
}

function redirectToErrorPage($message)
{
    echo "<script>
        Swal.fire({
            title: 'Error',
            text: '$message',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = '../master/error_page.php';
        });
    </script>";
    exit();
}
?>