<?php
require_once('vendor/autoload.php'); // Sesuaikan dengan path TCPDF jika tidak menggunakan Composer
include('db.php'); // Gantilah dengan nama file dan path yang sesuai
session_start();

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

// Buat instance TCPDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('UMKM');
$pdf->SetTitle('Income Report');
$pdf->SetSubject('Income Report');
$pdf->SetKeywords('TCPDF, PDF, income, report');

// Atur header dan footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Tambahkan halaman baru
$pdf->AddPage();

// Atur font
$pdf->SetFont('helvetica', '', 12);

// Tulis judul
$pdf->Cell(0, 10, 'Income Report', 0, 1, 'C');

// Spasi antara judul dan tabel
$pdf->Ln(10);

// Tulis tabel header
$pdf->Cell(40, 10, 'Period', 1);
$pdf->Cell(60, 10, 'Total Income', 1);
$pdf->Ln();

// Tulis data ke dalam tabel
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row['period'], 1);
        $pdf->Cell(60, 10, $row['total_income'], 1);
        $pdf->Ln();
    }
}

// Output file PDF
$pdf->Output('income_report.pdf', 'D');
exit;
?>
