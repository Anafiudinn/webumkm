<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$search = $_GET['q'];

$sql = "SELECT id, menu_name, price FROM menu WHERE user_id = '$user_id' AND menu_name LIKE '%$search%' LIMIT 50";
$result = $conn->query($sql);

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = [
        'id' => $row['id'],
        'text' => $row['menu_name'],
        'price' => $row['price']
    ];
}

echo json_encode(['items' => $items]);
?>
