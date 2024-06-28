<?php
require_once('vendor/autoload.php'); // Ganti dengan path yang sesuai jika tidak menggunakan Composer
session_start();
include('db.php');

// Ambil data income dari database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM stock WHERE user_id = '$user_id'";
$result = $conn->query($sql);

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
$pdf->Cell(40, 10, 'Date', 1);
$pdf->Cell(40, 10, 'Menu Name', 1);
$pdf->Cell(40, 10, 'Price', 1);
$pdf->Cell(40, 10, 'Quantity', 1);
$pdf->Cell(40, 10, 'Total', 1);
$pdf->Ln();

// Tulis data ke dalam tabel
$total_income = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row['date_added'], 1);
        $pdf->Cell(40, 10, $row['menu_name'], 1);
        $pdf->Cell(40, 10, $row['price'], 1);
        $pdf->Cell(40, 10, $row['quantity'], 1);
        $pdf->Cell(40, 10, $row['price'] * $row['quantity'], 1);
        $total_income += $row['price'] * $row['quantity'];
        $pdf->Ln();
    }
}

// Tulis total income
$pdf->Ln();
$pdf->Cell(0, 10, 'Total Income: ' . $total_income, 0, 1, 'R');

// Output file PDF
$pdf->Output('income_report.pdf', 'D');
exit;
?>
