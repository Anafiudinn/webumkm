<?php
include ('db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
      $_SESSION['user_id'] = $row['id'];
      header("Location: menu.php");
    } else {
      echo "Invalid password.";
    }
  } else {
    echo "username dan password belum terdaftar";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <title>Login - UMKM Es Teh</title>
  <style>
    body {
      background: lightblue;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background: #fff;
      padding: 2rem;
      border-radius: 25px;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      max-width: 300px;
      width: 100%;
    }

    .login-container h2 {
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
  <div class="login-container">
    <h2 class="text-center">Login</h2>
    <form method="post" action="login.php">
      <div class="form-group">
        <label for="username">username</label>
        <input type="text" name="username" class="form-control" id="email" placeholder="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
      <div class="error-message"></div>
    </form>
    <p class="text-center mt-3">Don't have an account? <a href="register.php">Register</a></p>
  </div>

  <script>
    window.onload = function () {
      document.body.classList.add('animate__animated', 'animate__fadeInUp');
    };
  </script>

</body>

</html>
<?
session_destroy();
?>