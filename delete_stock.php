<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$sql = "DELETE FROM stock WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    header("Location: menu.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
