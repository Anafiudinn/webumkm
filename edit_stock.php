<?php
include('db.php');
session_start();

include('templates/header.php');
    

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM stock WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu_name = $_POST['menu_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $date_added = $_POST['date_added'];

    $sql = "UPDATE stock SET menu_name='$menu_name', price='$price', quantity='$quantity', date_added='$date_added' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: menu.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Stock</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Edit Stock</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="menu_name">Menu Name:</label>
            <input type="text" class="form-control" id="menu_name" name="menu_name" value="<?php echo $row['menu_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo $row['price']; ?>" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" required>
        </div>
        <div class="form-group">
            <label for="date_added">Date Added:</label>
            <input type="date" class="form-control" id="date_added" name="date_added" value="<?php echo $row['date_added']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
