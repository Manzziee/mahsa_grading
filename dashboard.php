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
    <title>MAHSA Student Grading System</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <h1>MAHSA KOLEJ</h1>
        <h2>Student Grading System</h2>

        <p>
            Welcome,
            <?php echo htmlspecialchars($_SESSION['username']); ?>!
        </p>

        <hr>

        <h3>Student Management</h3>

        <a href="student.php">
            <button type="button">Manage Student Marks</button>
        </a>

        <br><br>

        <a href="logout.php">
            <button type="button">Logout</button>
        </a>

    </div>

</body>

</html>