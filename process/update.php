
<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

require_once __DIR__ . '/../database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: view.php");
    exit();
}

$id = (int)$_POST['id'];

$name = trim($_POST['student_name']);
$matric = trim($_POST['matric_no']);
$subject = trim($_POST['subject_name']);
$code = trim($_POST['subject_code']);

$t1 = (float)$_POST['test1'];
$t2 = (float)$_POST['test2'];
$final = (float)$_POST['final_exam'];

if (
    $id <= 0 ||
    $name === "" ||
    $matric === "" ||
    $subject === "" ||
    $code === "" ||
    $t1 < 0 || $t1 > 100 ||
    $t2 < 0 || $t2 > 100 ||
    $final < 0 || $final > 100
) {
    die("Invalid input. Please check all information and marks.");
}

$total = ($t1 * 0.20) + ($t2 * 0.30) + ($final * 0.50);

if ($total >= 80) {
    $grade = "A";
} elseif ($total >= 65) {
    $grade = "B";
} elseif ($total >= 50) {
    $grade = "C";
} elseif ($total >= 40) {
    $grade = "D";
} else {
    $grade = "E";
}

$sql = "UPDATE students SET
student_name=?,
matric_no=?,
subject_name=?,
subject_code=?,
test1=?,
test2=?,
final_exam=?,
total_marks=?,
grade=?
WHERE id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssssddddsi",
    $name,
    $matric,
    $subject,
    $code,
    $t1,
    $t2,
    $final,
    $total,
    $grade,
    $id
);

if (mysqli_stmt_execute($stmt)) {
    header("Location: view.php?updated=1");
    exit();
} else {
    echo "Update failed: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
