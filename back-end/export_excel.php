<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['id_exam'])) {
    $id_exam = $_POST['id_exam'];
    $numberofverses = $_POST['numberofverses'];

    $conn = new mysqli("localhost", "root", "", "dq");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM tb_correct_answer WHERE id_exam = '$id_exam'";
    $result = $conn->query($sql);

    // Create new PhpSpreadsheet object
    $spreadsheet = new Spreadsheet();

    // Get active sheet
    $sheet = $spreadsheet->getActiveSheet();

    // Add data headers to the Excel sheet
    $sheet->setCellValue('A1', 'File Name')
          ->setCellValue('B1', 'Student ID')
          ->setCellValue('C1', 'Total Score');

    // Add item headers
    $column = 'D'; // Start from column D
    for ($i = 1; $i <= $numberofverses; $i++) { // Assuming there are 80 items
        $sheet->setCellValue($column . '1', 'Item ' . $i);
        $column++;
    }

    // Populate data for each row
    $rowNumber = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $row['file_name'])
              ->setCellValue('B' . $rowNumber, $row['studentID'])
              ->setCellValue('C' . $rowNumber, $row['sumscore']);

        // Add item values
        $column = 'D'; // Start from column D
        for ($i = 1; $i <= $numberofverses; $i++) { // Assuming there are 80 items
            $sheet->setCellValue($column . $rowNumber, $row['item'.$i]);
            $column++;
        }

        $rowNumber++;
    }

    // Rename worksheet
    // $sheet->setTitle('Exam Report');

    // Create a new Xlsx object
    $writer = new Xlsx($spreadsheet);

    // Send the output to a client's web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="รายงานคะแนนรวม.xlsx"');
    header('Cache-Control: max-age=0');

    // Write the Excel file to the output
    $writer->save('php://output');

    $conn->close();
    exit;
} else {
    echo "No exam ID provided.";
}
?>
