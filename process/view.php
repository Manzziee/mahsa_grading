<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../database.php';

$sql = "SELECT * FROM students ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Records</title>

    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <div class="container">

        <h1>MAHSA KOLEJ</h1>
        <h2>Student Grading System</h2>
        <h3>Student Records</h3>

        <?php if (isset($_GET['updated'])) { ?>
            <p class="message">Student record updated successfully!</p>
        <?php } ?>

        <?php if (isset($_GET['deleted'])) { ?>
            <p class="message">Student record deleted successfully!</p>
        <?php } ?>

        <table>

            <tr>
                <th>Name</th>
                <th>Matric No</th>
                <th>Subject</th>
                <th>Subject Code</th>
                <th>Test 1</th>
                <th>Test 2</th>
                <th>Final Exam</th>
                <th>Total Marks</th>
                <th>Grade</th>
                <th>Action</th>
            </tr>

            <?php if (mysqli_num_rows($result) > 0) { ?>

                <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                    <tr>
                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>

                        <td><?php echo htmlspecialchars($row['matric_no']); ?></td>

                        <td><?php echo htmlspecialchars($row['subject_name']); ?></td>

                        <td><?php echo htmlspecialchars($row['subject_code']); ?></td>

                        <td><?php echo $row['test1']; ?></td>

                        <td><?php echo $row['test2']; ?></td>

                        <td><?php echo $row['final_exam']; ?></td>

                        <td><?php echo number_format($row['total_marks'], 2); ?></td>

                        <td><?php echo htmlspecialchars($row['grade']); ?></td>

                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>">
                                EDIT
                            </a>

                            <form action="delete.php" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this student?');">

                                <input type="hidden" name="id"
                                    value="<?php echo $row['id']; ?>">

                                <button type="submit">DELETE</button>

                            </form>
                        </td>
                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="10">No student records found.</td>
                </tr>

            <?php } ?>

        </table>

        <br>

        <a href="../student.php">Back to Student Form</a>

        <br><br>

        <a href="../dashboard.php">Back to Dashboard</a>

    </div>

</body>

</html>