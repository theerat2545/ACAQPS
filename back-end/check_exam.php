<?php

use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

session_start();
include ('../config.php');

if (isset($_GET['id_exam'])) {
    $id_exam = $_GET['id_exam'];

    // Construct SQL query to retrieve numberofverses from tb_exam
    $sql_exam = "SELECT numberofverses FROM tb_exam WHERE id_exam = '$id_exam'";
    $result_exam = $conn->query($sql_exam);

    if ($result_exam->num_rows > 0) {
        $row_exam = $result_exam->fetch_assoc();
        $numberofverses = $row_exam["numberofverses"];

        $numColumns = intval($numberofverses);

        $sql_detail = "SELECT id_exam,file_name,studentID,  ";
        for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
            if ($colIndex > 1) {
                $sql_detail .= ", ";
            }
            $sql_detail .= "item$colIndex";
        }
        $sql_detail .= " FROM tb_examdetail WHERE id_exam = '$id_exam'";

        $result_detail = $conn->query($sql_detail);

        if ($result_detail->num_rows > 0) {
            $result_answer = array();
            while ($row = $result_detail->fetch_assoc()) {
                $answer_exam = array();

                $id = $row['id_exam'];
                for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                    $answer_exam[] = $row["item$colIndex"];
                }

                // หยุดลูปหลังจากแสดงผลแถวแรก
                break;
            }
            // นำตัวแปร $file_name และ $studentID จาก $row ก่อนที่จะเริ่มลูปใหม่
            // $file_name = $row['file_name'];
            // $studentID = $row['studentID'];
            $id = $row['id_exam'];

            // Loop through each row in the result_detail
            $item_counts = array_fill(0, $numColumns, 0); // สร้างอาร์เรย์เพื่อเก็บจำนวนที่เป็น 1 ในแต่ละ item

            while ($row = $result_detail->fetch_assoc()) {
                $id = $row['id_exam'];
                $file_name = $row['file_name'];
                $studentID = $row['studentID'];

                // กำหนดค่า $row ให้กับ $answer_student
                $answer_student = array();
                for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                    $answer_student[] = $row["item$colIndex"];
                }

                // เริ่มลูปตามจำนวนข้อที่ต้องเปรียบเทียบ
                $result_row = array(); // สร้างอาร์เรย์เปล่าเพื่อเก็บผลลัพธ์

                for ($colIndex = 0; $colIndex < $numColumns; $colIndex++) {
                    // เปรียบเทียบค่าในตำแหน่งที่ $colIndex ของ $answer_exam และ $answer_student
                    $comparison = ($answer_exam[$colIndex] == $answer_student[$colIndex]) ? 1 : 0;

                    // นำผลการเปรียบเทียบมาเก็บในอาร์เรย์ $result_row
                    $result_row[] = $comparison;

                    // เพิ่มจำนวนที่เป็น 1 ในแต่ละ item ใน $item_counts
                    $item_counts[$colIndex] += $comparison;
                }

                // ดำเนินการ INSERT ข้อมูลในตาราง tb_correct_answer
                $insertSql = "INSERT INTO tb_correct_answer (id_exam, file_name, studentID, ";
                for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                    if ($colIndex > 1) {
                        $insertSql .= ", ";
                    }
                    $insertSql .= "item$colIndex";
                }
                $insertSql .= ") VALUES ('$id_exam', '$file_name', '$studentID', ";

                // Build the VALUES part of the INSERT query
                for ($colIndex = 0; $colIndex < $numColumns; $colIndex++) {
                    if ($colIndex > 0) {
                        $insertSql .= ", ";
                    }
                    $insertSql .= "'" . $result_row[$colIndex] . "'";
                }

                $insertSql .= ")";
                $insertResult = $conn->query($insertSql);
                if (!$insertResult) {
                    echo "Error inserting data: " . $conn->error;
                }

                // Clear the $result_row array for the next row
                $result_row = array();
            }
            $total_std = 0; // กำหนดค่าเริ่มต้นของตัวแปรเพื่อเก็บจำนวนนักศึกษา
            $sql = "SELECT COUNT(studentID) AS student_count FROM tb_correct_answer WHERE id_exam = $id_exam";

            // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
            $result = $conn->query($sql);

            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if ($result->num_rows > 0) {
                // ดึงข้อมูล
                $row = $result->fetch_assoc();
                $total_std = $row["student_count"]; // กำหนดค่าจำนวนนักศึกษา
                // echo "จำนวนนักศึกษา: " . $total_std;
            } else {
                echo "ไม่พบข้อมูล";
            }

            $total_counts = []; // กำหนด $total_counts เป็น array เปล่าก่อนใช้งาน

            // นับจำนวนที่เป็น 1 ในแต่ละ item และเพิ่มใน $total_counts
            foreach ($item_counts as $index => $count) {
                if (!isset($total_counts[$index])) {
                    $total_counts[$index] = 0; // กำหนดค่าเริ่มต้นให้เป็น 0 ถ้ายังไม่มีค่าใน $total_counts
                }
                $total_counts[$index] += $count;
            }

            if (!empty($total_counts)) {
                // ตรวจสอบว่า $numColumns ถูกกำหนดค่าหรือไม่
                if (!isset($numColumns)) {
                    echo "Error: Number of columns is not defined.";
                } else {
                    // ตรวจสอบจำนวนของคอลัมน์ในตาราง `item_counts` และจำนวนของค่าใน $total_counts
                    $numTotalCounts = count($total_counts);
                    if ($numTotalCounts !== $numColumns) {
                        echo "Error: Number of columns in the item_counts table does not match the number of values.";
                    } else {
                        // สร้างคำสั่ง SQL INSERT และ execute คำสั่ง SQL ต่อไป
                        $insertTotalCountsSql = "INSERT INTO item_counts (id_exam,numberofverses,total_std,";
                        for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                            if ($colIndex > 1) {
                                $insertTotalCountsSql .= ", ";
                            }
                            $insertTotalCountsSql .= "item$colIndex";
                        }
                        $insertTotalCountsSql .= ") VALUES ('$id_exam','$numberofverses','$total_std',";

                        for ($colIndex = 0; $colIndex < $numColumns; $colIndex++) {
                            if ($colIndex > 0) {
                                $insertTotalCountsSql .= ", ";
                            }
                            $insertTotalCountsSql .= "'" . $total_counts[$colIndex] . "'";
                        }
                        $insertTotalCountsSql .= ")";

                        $insertTotalCountsResult = $conn->query($insertTotalCountsSql);
                        if (!$insertTotalCountsResult) {
                            echo "Error inserting data: " . $conn->error;
                        } else {
                            echo "Total counts inserted successfully!";
                        }
                    }
                }
            } else {
                echo "Error: Total counts is empty or not defined.";
            }



            // ตรวจสอบผลลัพธ์ใน $item_counts
            // for ($colIndex = 0; $colIndex < $numColumns; $colIndex++) {
            //     echo "Item " . ($colIndex + 1) . " has " . $item_counts[$colIndex] . " correct answers." . PHP_EOL;
            // }

        }
    }

    $selectSql = "SELECT*FROM tb_examdetail WHERE id_exam = $id_exam";
    $resultSelect = $conn->query($selectSql);

    if ($resultSelect->num_rows > 0) {
        while ($row = $resultSelect->fetch_assoc()) {
            $file_name = $row['file_name'];
            $studentID = $row['studentID'];
            $id = $row['id_exam'];

            // ใส่เครื่องหมายเริ่มต้นและสิ้นสุดเพื่อระบุค่าเป็นสตริงใน SQL
            $upSql = "UPDATE tb_correct_answer SET file_name = '$file_name', studentID = '$studentID' WHERE id = $id";
            $reup = $conn->query($upSql);
        }
    }

    $SD = 0;


    // สร้างคำสั่ง SQL เพื่อดึงข้อมูล user_id, exam_id, exam_name, numberofverses
    $query = "SELECT exam_runID, exam_id, exam_name,numberofverses FROM tb_exam WHERE id_exam = '$id_exam'";
    $re = $conn->query($query);
    // ตรวจสอบว่ามีข้อมูลที่ค้นหาเจอหรือไม่
    if ($re->num_rows > 0) {
        $row = $re->fetch_assoc();
        $numberofverses = $row["numberofverses"];

        // คำนวณจำนวนคอลัมน์ที่ต้องแสดงในตาราง item
        $numColumns = intval($numberofverses);

        $sql = "SELECT id,";
        for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
            $sql .= "item$colIndex";
            if ($colIndex < $numColumns) {
                $sql .= ", "; // เพิ่มเครื่องหมาย , ระหว่างคอลัมน์
            }
        }
        $sql .= " FROM tb_correct_answer WHERE id_exam = '$id_exam'";

        $result = $conn->query($sql);

        $totalSumScore = 0;
        $totalSumScoreSquared = 0;
        if ($result->num_rows > 0) {
            $scores = [];
            $correctCounts = [];
            while ($row = $result->fetch_assoc()) {
                $responses = [];
                for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                    $responses[] = $row["item$colIndex"];
                }

                // หาผลรวมและผลรวมกำลัง 2
                $sumScore = array_sum($responses);
                $ss = array_sum($responses);
                $sumScoreSquared = pow($ss, 2);
                // echo "s" . $sumScore . '<br>';
                // echo "sumsq" . $sumScoreSquared . '<br>';
                $id = $row['id'];

                $updateSql = "UPDATE tb_correct_answer SET sumscore = $sumScore WHERE id=$id";
                $conn->query($updateSql);

                $scores[] = $sumScore; // เก็บผลรวมคะแนน

                // เพิ่มส่วนนับผู้ตอบถูกในแต่ละคอลัมน์
                for ($colIndex = 1; $colIndex <= $numColumns; $colIndex++) {
                    $isCorrect = $row["item$colIndex"] == 1 ? 1 : 0;
                    $correctCounts["item$colIndex"][] = $isCorrect;
                }

                $totalSumScore += $sumScore;
                $totalSumScoreSquared += $sumScoreSquared;
            }
            // echo "<br>";
            // echo "totalSumScore: $totalSumScore";
            // echo "<br>";
            // echo "totalSumScoreSquared: $totalSumScoreSquared";
            // echo "<br>";
            // นับจำนวนผู้เข้าสอบทั้งหมดแล้วเก็บไว้ในตัวแปร $totalParticipants
            $totalParticipants = count($scores);

            // ตรวจสอบผลลัพธ์ของการนับจำนวนผู้ตอบถูกในแต่ละคอลัมน์

            // echo "Number of participants: $totalParticipants<br>";

            // หาค่าความแปรปรวน
            $sd = (($totalParticipants * $totalSumScoreSquared) - pow($totalSumScore, 2)) / pow($totalParticipants, 2);
            $SD = number_format($sd, 2);
            // echo $SD . "= (($totalParticipants * $totalSumScoreSquared) - $totalSumScore ** 2) / ($totalParticipants ** 2)";
        }
    }
    $sum_pq = 0; // กำหนดค่าเริ่มต้นให้ $sum_pq ก่อนเข้าสู่ลูป
    foreach ($correctCounts as $colName => $counts) {
        $totalCorrectCount = array_sum($counts);
        $pp = $totalCorrectCount / $totalParticipants;
        $p = number_format($pp, 2);
        $q = (1 - $p);
        $pq = $p * $q;
        $Sum_pq = number_format($pq, 2);
        $sum_pq += $Sum_pq; // เพิ่มค่า $pq เข้ากับผลรวมทั้งหมด
        // echo "totalCorrectCount: $totalCorrectCount";
        // echo "<br>";
        // echo "p: $p";
        // echo "<br>";
        // echo "q: $q";
        // echo "<br>";
        // echo "pq: $pq";
        // echo "<br>";
    }

    // echo "Sum of pq: $sum_pq";

    $arraymax = array();
    $arraymin = array();

    $sql = "SELECT*FROM tb_correct_answer WHERE id_exam = '$id_exam'";
    $result = $conn->query($sql);
    $allstudent = $result->num_rows;
    // echo "allstd" . $allstudent . "<br>";
    $percen = floor(($allstudent * 27) / 100);
    // echo "percen" . $percen . "<br>";

    $sqlmax = "SELECT*FROM tb_correct_answer WHERE id_exam = '$id_exam' ORDER BY sumscore DESC LIMIT $percen";
    $resultmax = $conn->query($sqlmax);
    while ($rowmax = $resultmax->fetch_assoc()) {
        //  echo $rowmax['sumscore'] ."<br>";
        array_push($arraymax, $rowmax['studentID']);
    }

    $sqlmin = "SELECT*FROM tb_correct_answer WHERE id_exam = '$id_exam' ORDER BY sumscore ASC LIMIT $percen";
    $resultmin = $conn->query($sqlmin);
    while ($rowmin = $resultmin->fetch_assoc()) {
        // echo $rowmin['sumscore'] ."<br>";
        array_push($arraymin, $rowmin['studentID']);
    }

    // สร้างคำสั่ง SQL เพื่อดึงข้อมูล user_id, exam_id, exam_name, numberofverses
    $sql = "SELECT user_id, exam_id, exam_name, numberofverses FROM tb_exam WHERE id_exam = '$id_exam'";
    $result = $conn->query($sql);

    // ตรวจสอบว่ามีข้อมูลที่ค้นหาเจอหรือไม่
    if ($result->num_rows > 0) {

        // ดึงข้อมูลจากแถวแรกเนื่องจาก numberofverses เป็นข้อมูลเดียว
        $row = $result->fetch_assoc();
        $user_id = $row["user_id"];
        $exam_id = $row["exam_id"];
        $exam_name = $row["exam_name"];
        $numberofverses = $row["numberofverses"];

        // $pq = [];
        for ($checktest = 1; $checktest <= $numberofverses; $checktest++) {

            $sqlchecktest = "SELECT*FROM tb_correct_answer WHERE id_exam = '$id_exam'";
            $resultchecktest = $conn->query($sqlchecktest);
            $rowchecktest = $resultchecktest->fetch_assoc();
            // echo $rowchecktest["item$checktest"];
            //echo "<br>";
            $summax = 0;
            $summin = 0;

            for ($checkstdmax = 0; $checkstdmax <= count($arraymax) - 1; $checkstdmax++) {
                $sqlstdmax = "SELECT*FROM tb_correct_answer WHERE studentID = '$arraymax[$checkstdmax]'";
                $resultstdmax = $conn->query($sqlstdmax);
                $rowstdmax = $resultstdmax->fetch_assoc();
                // echo $rowchecktest["item$checktest"];
                // echo $rowstdmax["item$checktest"];

                if ($rowstdmax["item$checktest"] == 1) {
                    $summax++;
                    // echo $sum;
                }
            }

            for ($checkstdmin = 0; $checkstdmin <= count($arraymin) - 1; $checkstdmin++) {
                $sqlstdmin = "SELECT*FROM tb_correct_answer WHERE studentID = '$arraymin[$checkstdmin]'";
                $resultstdmin = $conn->query($sqlstdmin);
                $rowstdmin = $resultstdmin->fetch_assoc();
                // echo $rowchecktest["item$checktest"];
                // echo $rowstdmin["item$checktest"];

                if ($rowstdmin["item$checktest"] == 1) {
                    $summin++;
                    // echo $sum;
                }
            }
            $dif = ($summax + $summin) / ($percen * 2);
            $difficulty = number_format($dif, 2);
            if ($difficulty >= 0.81 and $difficulty <= 1) {
                $diftype = "ง่ายมาก (ควรปรับปรุงหรือตัดทิ้ง)";
            } else if ($difficulty >= 0.60) {
                $diftype = "ค่อนข้างง่าย (ดี)";
            } else if ($difficulty >= 0.40) {
                $diftype = "ยากพอเหมาะ (ดีมาก)";
            } else if ($difficulty >= 0.20) {
                $diftype = "ยาก(ดี)";
            } else if ($difficulty > 0) {
                $diftype = "ยากมาก (ควรปรับปรุงหรือตัดทิ้ง)";
            }
            // $q = (1 - $difficulty);
            // $pq[] = ($difficulty * $q);

            $dis = ($summax - $summin) / $percen;
            $discrimination = number_format($dis, 2);
            if ($discrimination >= 0.60 and $discrimination <= 1) {
                $distype = "อำนาจจำแนกดีมาก";
            } else if ($discrimination >= 0.40) {
                $distype = "อำนาจจำแนกดี";
            } else if ($discrimination >= 0.20) {
                $distype = "อำนาจจำแนกพอใช้";
            } else if ($discrimination >= 0.10) {
                $distype = "อำนาจจำแนกต่ำ (ควรปรับปรุงหรือตัดทิ้ง)";
            } else if ($discrimination > -1) {
                $distype = "อำนาจจำแนกต่ำมาก (ควรปรับปรุงหรือตัดทิ้ง)";
            }

            $answerSql = "INSERT INTO tb_answer (id_exam,ans_item,det_difficulty,det_p_meaning,det_discrimination,det_r_meaning)
            VALUE ('$id_exam','$checktest','$difficulty','$diftype','$discrimination','$distype')";
            $conn->query($answerSql);
        }
        // $totalSum_pq = array_sum($pq);
        // echo $totalSum_pq;
        // echo $pq;
    }
    //หาค่าความเชื่อมั่น
    $R = ($numberofverses / ($numberofverses - 1)) * (1 - ($sum_pq / $SD));
    // echo "<br>";
    // echo  $R . "=" . $numberofverses . "/" . "(" . $numberofverses . "-" . "1" . "))" . "*" . "(1-(" . $sum_pq . "/" . $SD . ")))";

    $Rkr20 = number_format($R, 2);
    $percenRkr20 = $Rkr20 * 100;
    $m_percenRkr20 = "ค่าความเชื่อมั่นของแบบทดสอบชุดนี้มีความเชื่อมั่น" . " " . $percenRkr20 . " " . "%";
    if ($Rkr20 >= 0.70) {
        $rel = "แบบทดสอบชุดนี้มีความเหมาะสม";
    } else {
        $rel = "แบบทดสอบชุดนี้ควรทำการแก้ไข อาจจะตัดบางข้อที่ค่าอำนาจจำแนกต่ำออก";
    }
    $reliabilitySql = "INSERT INTO result_reliability (id_exam, reliability, percen_reliability, rel_reliability, date_time)
            VALUE ('$id_exam','$Rkr20',' $m_percenRkr20','$rel',NOW())";
    $conn->query($reliabilitySql);

    // ทำการอัปเดตคอลัมน์ status เป็น 1
    $updateStatusQuery = "UPDATE tb_exam SET status = 'ประมวลผลเสร็จสิ้น' WHERE id_exam = '$id_exam'";
    $conn->query($updateStatusQuery);
    echo "<script>window.location.href = '../report.php'</script>";
}
