<?php
include('db.php');
session_start();

 include('templates/header.php');
    

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$date_from = isset($_POST['date_from']) ? $_POST['date_from'] : date('Y-m-01');
$date_to = isset($_POST['date_to']) ? $_POST['date_to'] : date('Y-m-t');
$report_type = isset($_POST['report_type']) ? $_POST['report_type'] : 'daily';

$query = "";
switch ($report_type) {
    case 'daily':
        $query = "SELECT DATE(date_added) AS period, SUM(price * quantity) AS total_income 
                  FROM stock 
                  WHERE user_id = '$user_id' AND date_added BETWEEN '$date_from' AND '$date_to' 
                  GROUP BY DATE(date_added)";
        break;
    case 'weekly':
        $query = "SELECT YEARWEEK(date_added) AS period, SUM(price * quantity) AS total_income 
                  FROM stock 
                  WHERE user_id = '$user_id' AND date_added BETWEEN '$date_from' AND '$date_to' 
                  GROUP BY YEARWEEK(date_added)";
        break;
    case 'monthly':
        $query = "SELECT DATE_FORMAT(date_added, '%Y-%m') AS period, SUM(price * quantity) AS total_income 
                  FROM stock 
                  WHERE user_id = '$user_id' AND date_added BETWEEN '$date_from' AND '$date_to' 
                  GROUP BY DATE_FORMAT(date_added, '%Y-%m')";
        break;
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Income</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <br>
    <h2>Rekap Income</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="date_from">dari:</label>
            <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo $date_from; ?>" required>
        </div>
        <div class="form-group">
            <label for="date_to">sampai:</label>
            <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo $date_to; ?>" required>
        </div>
        <div class="form-group">
            <label for="report_type">Pilih tipe:</label>
            <select class="form-control" id="report_type" name="report_type" required>
                <option value="daily" <?php echo $report_type == 'daily' ? 'selected' : ''; ?>>Harian</option>
                <option value="weekly" <?php echo $report_type == 'weekly' ? 'selected' : ''; ?>>Mingguan</option>
                <option value="monthly" <?php echo $report_type == 'monthly' ? 'selected' : ''; ?>>Bulanan</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
        <a href="in_pdf.php" class="btn btn-danger ">Export to PDF</a>
    </form>

        <!-- Tabel atau konten lain di sini -->
   
    <div class="table-responsive mt-4">
    <table class="table table-bordered mt-4 bg-secodnary">
    <thead class="thead-dark">
            <tr>
                <th>Period</th>
                <th>Total Income</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['period']; ?></td>
                    <td><?php echo $row['total_income']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
</body>
</body>
</html>
<?
session_destroy();
?>
