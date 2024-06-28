<?php
include('db.php');
session_start();    
    include 'templates/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }
    .wrapper {
        display: flex;
    }
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 200px;
        background-color: #343a40; /* Warna sidebar */
        color: #fff;
        transition: all 0.3s;
        z-index: 1000; /* Menempatkan sidebar di atas konten */
    }
    .sidebar.open {
        width: 250px;
    }
    .sidebar.close {
        width: 80px;
    }
    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }
    .sidebar ul li {
        padding: 15px;
        font-size: 1.2em;
        cursor: pointer;
    }
    .sidebar ul li:hover {
        background-color: #495057; /* Warna background item saat dihover */
    }
    .sidebar ul li a {
        color: #fff;
        text-decoration: none;
    }
    .content {
       display: contents;
       padding: 8px;
    }
    .content img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: auto; /* Untuk memastikan gambar ditengah */
}

.toggle-btn {
        position: absolute;
        left: 10px;
        top: 20px;
        cursor: pointer;
        font-size: 1.5em;
        color: #fff;
        z-index: 2000; /* Menempatkan tombol hamburger di atas sidebar */
        display: none; /* Sembunyikan tombol hamburger di desktop */
    }
    @media (max-width: 768px) {
        .sidebar {
            width: 80px;
        }
        .content {
            margin-left: 80px;
        }
           
        .toggle-btn {
            left: 80px;
        }
    }
</style>
</head>
<body>
    <div class="container">
        <br>
    <!-- Content -->
    <div class="content">
        <h2>Welcome to My Website</h2>
        <p>Mahasiswa Universita Semarang</p>
        <img src="docs/das.jpg" alt="Foto Anda" style="width: 400%; max-width: 700px margin=fit-content;">
        </div>
    </div>
</div>

<!-- Bootstrap JS (required for Bootstrap components like navbar) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('open');
    }
</script>
</body>
</html>
<?
session_destroy();
?>
