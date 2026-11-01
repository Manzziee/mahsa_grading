<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../database.php';

$success = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_name = trim($_POST['student_name']);
    $matric_no = trim($_POST['matric_no']);
    $subject_name = trim($_POST['subject_name']);
    $subject_code = trim($_POST['subject_code']);

    $test1 = (float) $_POST['test1'];
    $test2 = (float) $_POST['test2'];
    $final_exam = (float) $_POST['final_exam'];

    if (
        $student_name == "" ||
        $matric_no == "" ||
        $subject_name == "" ||
        $subject_code == "" ||
        $test1 < 0 || $test1 > 100 ||
        $test2 < 0 || $test2 > 100 ||
        $final_exam < 0 || $final_exam > 100
    ) {
        $error = "Please fill in all information. Marks must be between 0 and 100.";
    } else {

        // Calculate total marks
        $total_marks = ($test1 * 0.20) +
            ($test2 * 0.30) +
            ($final_exam * 0.50);

        // Calculate grade
        if ($total_marks >= 80) {
            $grade = "A";
        } elseif ($total_marks >= 65) {
            $grade = "B";
        } elseif ($total_marks >= 50) {
            $grade = "C";
        } elseif ($total_marks >= 40) {
            $grade = "D";
        } else {
            $grade = "E";
        }

        // Save into database
        $sql = "INSERT INTO students
        (student_name, matric_no, subject_name, subject_code,
        test1, test2, final_exam, total_marks, grade)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "ssssdddds",
            $student_name,
            $matric_no,
            $subject_name,
            $subject_code,
            $test1,
            $test2,
            $final_exam,
            $total_marks,
            $grade
        );

        if (mysqli_stmt_execute($stmt)) {
            $success = true;
        } else {
            $error = "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Save Student Record</title>

    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <div class="container">

        <h1>MAHSA KOLEJ</h1>
        <h2>Student Grading System</h2>

        <?php if ($success) { ?>

            <h3 class="message">Student Data Saved Successfully!</h3>

            <table>

                <tr>
                    <th>Information</th>
                    <th>Details</th>
                </tr>

                <tr>
                    <td>Student Name</td>
                    <td><?php echo htmlspecialchars($student_name); ?></td>
                </tr>

                <tr>
                    <td>Matric Number</td>
                    <td><?php echo htmlspecialchars($matric_no); ?></td>
                </tr>

                <tr>
                    <td>Subject</td>
                    <td><?php echo htmlspecialchars($subject_name); ?></td>
                </tr>

                <tr>
                    <td>Subject Code</td>
                    <td><?php echo htmlspecialchars($subject_code); ?></td>
                </tr>

                <tr>
                    <td>Test 1</td>
                    <td><?php echo $test1; ?></td>
                </tr>

                <tr>
                    <td>Test 2</td>
                    <td><?php echo $test2; ?></td>
                </tr>

                <tr>
                    <td>Final Exam</td>
                    <td><?php echo $final_exam; ?></td>
                </tr>

                <tr>
                    <td>Total Marks</td>
                    <td><?php echo number_format($total_marks, 2); ?></td>
                </tr>

                <tr>
                    <td>Final Grade</td>
                    <td><?php echo htmlspecialchars($grade); ?></td>
                </tr>

            </table>

        <?php } elseif ($error != "") { ?>

            <h3 class="error">
                <?php echo htmlspecialchars($error); ?>
            </h3>

        <?php } ?>

        <br>

        <a href="../student.php">Add Another Student</a>

        <br><br>

        <a href="view.php">View Student Records</a>

        <br><br>

        <a href="../dashboard.php">Back to Dashboard</a>

    </div>

</body>

</html>