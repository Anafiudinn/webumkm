<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email']; // Tambahkan input untuk email
    $jenis_mitra = $_POST['jenis_mitra']; // Tambahkan input untuk jenis mitra
    $nomor_hp = $_POST['nomor_hp']; // Tambahkan input untuk nomor HP

    $sql = "INSERT INTO users (username, password, email, jenis_mitra, nomor_hp) 
            VALUES ('$username', '$password', '$email', '$jenis_mitra', '$nomor_hp')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Registrasi - UMKM Es Teh</title>
    <style>
        body {
            background: mediumpurple;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background: #fff;
            padding: 2rem;
            border-radius: 25px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            max-width: 400px;
            width: 100%;
        }
        .register-container h2 {
            margin-bottom: 1.5rem;
            color: #343a40;
        }
        .form-group label {
            color: #495057;
        }
        .btn-primary {
            width: 100%;
        }
        .error-message {
            color: #dc3545;
            margin-top: 1rem;
        }
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            color: #6c757d;
            text-align: center;
            padding: 1rem 2;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2 class="text-center">Registrasi</h2>
        <form method="post" action="register.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="jenis_mitra">Jenis Mitra</label>
                <input type="text" name="jenis_mitra" class="form-control" id="jenis_mitra" placeholder="Jenis Mitra" required>
            </div>
            <div class="form-group">
                <label for="nomor_hp">Nomor HP</label>
                <input type="text" name="nomor_hp" class="form-control" id="nomor_hp" placeholder="Nomor HP" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
    <!-- <div class="footer">
        <p>&copy; UMKM Es Teh. by Ahmad Anafi Khoirudin</p>
    </div> -->
</body>
</html>
