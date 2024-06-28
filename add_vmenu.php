<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_name = $_POST['menu_name'];
    $price = $_POST['price'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO menu (menu_name, price, user_id) VALUES ('$menu_name', '$price', '$user_id')";

    if ($conn->query($sql) === TRUE) {
        header("Location: add_stock.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

include('templates/header.php');
?>

<div class="container">
    <h2>Add New Menu</h2>
    <form action="add_vmenu.php" method="post">
        <div class="form-group">
            <label for="menu_name">Menu Name:</label>
            <input type="text" class="form-control" id="menu_name" name="menu_name" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Menu</button>
    </form>
</div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
