<?php
include('db.php');
session_start();

    

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$limit = 10;  // Number of entries per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query to get entries based on search//
$sql = "SELECT * FROM stock WHERE user_id = '$user_id' AND menu_name LIKE '%$search%'";
$result = $conn->query($sql);

// Query to get total number of entries


// Query to get entries for the current page
$sql = "SELECT * FROM stock WHERE user_id = '$user_id' AND menu_name LIKE '%$search%' ORDER BY date_added DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Query untuk mendapatkan jumlah total entri berdasarkan pencarian dan user_id
$total_query = "SELECT COUNT(*) AS total FROM stock WHERE user_id = '$user_id' AND menu_name LIKE '%$search%'";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_entries = $total_row['total'];
$total_pages = ceil($total_entries / $limit);

$total_income = 0;
$stocks = [];
while ($row = $result->fetch_assoc()) {
    $total_income += $row['price'] * $row['quantity'];
    $stocks[] = $row;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM stock WHERE user_id = '$user_id'";
$result = $conn->query($sql);

// Menghitung total income
// $total_income = 0;
// $stocks = [];
// while ($row = $result->fetch_assoc()) {
//     $total_income += $row['price'] * $row['quantity'];
//     $stocks[] = $row;
// }

include('templates/header.php');
?>
<!DOCTYPE html>
<html>
<head>
    <br>
    <title>Menu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>

</style>
<body>  
<div class="container">
    <h2>Menu</h2>
    <form method="GET" action="menu.php" class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search for menu" aria-label="Search">
        <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Cari</button>
    </form>
    <br>
    <a href="add_stock.php" class="btn btn-success">Tambah Menu</a>
    <a href="income.php" class="btn btn-info">View Income</a>
    <a href="export_excel.php" class="btn btn-secondary">Export to Excel</a>
    <div class="table-responsive mt-4">
    <?php if (!empty($stocks)) { ?>
    <table class="table table-bordered mt-4 bg-secodnary">
    <thead class="thead-dark">
            <tr>
                <th>Menu Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($stocks as $row) { ?>
                <tr>
                    <td><?php echo $row['menu_name']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo $row['price'] * $row['quantity']; ?></td>
                    <td><?php echo $row['date_added']; ?></td>
                    
                    <td>
                        <a href="edit_stock.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_stock.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } else if (isset($error_message)) { ?>
        <div class="alert alert-warning"><?php echo $error_message; ?></div>
    <?php } ?>
</div>
</div>
<div class="alert alert-info mt-4">
        <strong>Total Income:</strong> <?php echo $total_income; ?>
    </div>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>">Previous</a>
            </li>

            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
                    <a class="page-link" href="menu.php?page=<?= $i; ?>"> <?= $i; ?> </a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?php if($page >= $total_pages) { echo 'disabled'; } ?>">
                <a class="page-link" href="<?php if($page >= $total_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">Next</a>
            </li>
        </ul>
    </nav>
</div>
</body>
</html>
<?
session_destroy();
?>