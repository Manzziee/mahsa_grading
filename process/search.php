<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../database.php';
$student = null;
$not_found = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matric_no = trim($_POST['matric_no']);

    $sql = "SELECT * FROM students WHERE matric_no = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $matric_no);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
    } else {
        $not_found = true;
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Student Record</title>

    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <div class="container">

        <h1>MAHSA KOLEJ</h1>
        <h2>Student Grading System</h2>

        <?php if ($student) { ?>

            <h3>Student Record Found</h3>

            <table>

                <tr>
                    <th>Information</th>
                    <th>Details</th>
                </tr>

                <tr>
                    <td>Student Name</td>
                    <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                </tr>

                <tr>
                    <td>Matric Number</td>
                    <td><?php echo htmlspecialchars($student['matric_no']); ?></td>
                </tr>

                <tr>
                    <td>Subject</td>
                    <td><?php echo htmlspecialchars($student['subject_name']); ?></td>
                </tr>

                <tr>
                    <td>Subject Code</td>
                    <td><?php echo htmlspecialchars($student['subject_code']); ?></td>
                </tr>

                <tr>
                    <td>Test 1</td>
                    <td><?php echo $student['test1']; ?></td>
                </tr>

                <tr>
                    <td>Test 2</td>
                    <td><?php echo $student['test2']; ?></td>
                </tr>

                <tr>
                    <td>Final Exam</td>
                    <td><?php echo $student['final_exam']; ?></td>
                </tr>

                <tr>
                    <td>Total Marks</td>
                    <td><?php echo number_format($student['total_marks'], 2); ?></td>
                </tr>

                <tr>
                    <td>Grade</td>
                    <td><?php echo htmlspecialchars($student['grade']); ?></td>
                </tr>

            </table>

        <?php } elseif ($not_found) { ?>

            <h3 class="error">Student record not found!</h3>

        <?php } else { ?>

            <h3>No search information submitted.</h3>

        <?php } ?>

        <br>

        <a href="../student.php">Back to Student Form</a>

        <br><br>

        <a href="view.php">View All Student Records</a>

        <br><br>

        <a href="../dashboard.php">Back to Dashboard</a>

    </div>

</body>

</html>