<?php
require 'database.php';

$name = $_POST["name"];
$cid = $_POST["cid"];
$email = $_POST["email"];
$password = $_POST["password"];

if (!preg_match('/^[a-zA-Z0-9._-]+@iitp.ac.in/', $email)) {
    echo "Error: Invalid email";
}

$sql = "SELECT * FROM company WHERE email='$email'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "Error: Email already exists";
    exit();
}

if (strlen($password) < 8) {
    echo "Error: Password must be at least 8 characters long";
    exit();
} elseif (!preg_match("#[0-9]+#", $password)) {
    echo "Error: Password must contain at least one number";
    exit();
} elseif (!preg_match("#[a-zA-Z]+#", $password)) {
    echo "Error: Password must contain at least one letter";
    exit();
}

$sql = "INSERT INTO company (cid, name, email, password) VALUES ('$cid', '$name', '$email', '$password')";
if ($conn->query($sql) === TRUE) {
    echo "Account created successfully";
} else {
    echo "Error: " . mysqli_error($conn);
}

$conn->close();
header("Location: comp_login_page.html");
exit();
?>