<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil informasi pengguna dari database
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $username = $user['username'];
    $email = $user['email'];
    $jenis_mitra = $user['jenis_mitra'];
    $nomor_hp = $user['nomor_hp'];
} else {
    echo "User not found.";
    exit();
}

// Sisipkan header atau bagian lainnya di sini
include('templates/header.php');
?>

<div class="container">
    <br>
    <h2>User Profile</h2>
    <br>
    <table class="table table-bordered">
        <tr>
            <th>Username</th>
            <td><?php echo $user['username']; ?></td>
        </tr>
        <tr>
        <th>Email</th>
        <td><?php echo $user['email']; ?></td>
        </tr>
        <tr>
        <th>jenis_mitra</th>
        <td><?php echo $user['jenis_mitra']; ?></td>
        </tr>
        <th>Nmoer handpone</th>
        <td><?php echo $user['nomor_hp']; ?></td>
        </tr>
    </table>
</div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
