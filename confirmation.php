<?php
ini_set('display_errors', 1);
error_reporting(-1);

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: stud_login_page.html");
    exit();
}

require 'database.php';

$user_id = $_SESSION["user_id"];
$cid = $_SESSION["cid"];
$password = $_POST['password'];
$role = $_SESSION["role"];
$sql = "SELECT * FROM Student WHERE roll_no='$user_id'";
$result = $conn->query($sql);

$row = $result->fetch_assoc();
$user_password = $row["password"];
if ($password != $user_password) {
  echo "Error: Invalid password";
  exit();
}

$sql = "INSERT INTO application (roll_no, cid,role) VALUES ('$user_id', '$cid','$role')";
if ($conn->query($sql) === TRUE) {
    echo "Applied successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}

header("Location: stud_dashboard.php");
$conn->close();
exit();
?>