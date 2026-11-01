<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Information</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <h1>MAHSA KOLEJ</h1>
        <h2>Student Grading System</h2>

        <h3>Student Information Form</h3>

        <form action="process/save.php" method="POST">

            <label>Student Name</label>
            <input type="text" name="student_name" required>

            <label>Matric Number</label>
            <input type="text" name="matric_no" required>

            <label>Subject Name</label>
            <input type="text" name="subject_name" required>

            <label>Subject Code</label>
            <input type="text" name="subject_code" required>

            <label>Test 1 (20%)</label>
            <input type="number" name="test1"
                min="0" max="100" step="0.01" required>

            <label>Test 2 (30%)</label>
            <input type="number" name="test2"
                min="0" max="100" step="0.01" required>

            <label>Final Examination (50%)</label>
            <input type="number" name="final_exam"
                min="0" max="100" step="0.01" required>

            <br><br>

            <button type="submit">SUBMIT</button>

        </form>

        <hr>

        <h3>Search Student Record</h3>

        <form action="process/search.php" method="POST">

            <label>Matric Number</label>

            <input type="text"
                name="matric_no"
                placeholder="Enter Matric Number"
                required>

            <button type="submit">SEARCH</button>

        </form>

        <hr>

        <h3>View All Student Records</h3>

        <a href="process/view.php">
            <button type="button">VIEW STUDENTS</button>
        </a>

        <br><br>

        <a href="dashboard.php">Back to Dashboard</a>

    </div>

</body>

</html>