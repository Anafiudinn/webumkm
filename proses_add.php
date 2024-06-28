<?php
session_start();
include('db.php'); // Konfigurasi koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_name = $_POST['menu_name'];
    $price = $_POST['price'];

    // Siapkan dan jalankan pernyataan SQL untuk menambahkan menu baru
    $stmt = $conn->prepare("INSERT INTO menu (menu_name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $menu_name, $price);

    if ($stmt->execute()) {
        // Jika berhasil, alihkan ke halaman menu dengan pesan sukses
        header("Location: add_stock.php?message=Menu added successfully");
    } else {
        // Jika gagal, tampilkan pesan kesalahan
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
