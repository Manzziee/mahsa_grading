<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
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

        <h3>Login</h3>

        <form action="login.php" method="POST">

            <label>Username</label>
            <input type="text" name="username"
                placeholder="Enter Username" required>

            <label>Password</label>
            <input type="password" name="password"
                placeholder="Enter Password" required>

            <button type="submit">LOGIN</button>

        </form>

    </div>

</body>

</html>