<?php
ini_set('display_errors', 1);
error_reporting(-1);
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: comp_login_page.html");
    exit();
}
$user_id = $_SESSION["user_id"];

require 'database.php';

$program = $_POST["program"];
$cpi = $_POST["cpi"];
$marks10 = $_POST["marks10"];
$marks12 = $_POST["marks12"];
$sector = $_POST["sector"];
$salary = $_POST["package"];
$mode = $_POST["mode"];

$sql = "SELECT * FROM company WHERE cid='$user_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$name = $row["name"];


$sql = "INSERT INTO job (cid,name,minimum_10marks, minimum_12marks, minimum_cpi, sector, salary, interview_type, program) VALUES ('$user_id','$name', '$marks10', '$marks12', '$cpi', '$sector','$salary','$mode','$program')";

if ($conn->query($sql) === TRUE) {
    $conn->close();
    header("Location: comp_dashboard.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
    $conn->close();
}
?>