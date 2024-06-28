<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];
    $date_added = $_POST['date_added'];
    $user_id = $_SESSION['user_id'];

    // Ambil harga dari menu
    $menu_query = "SELECT menu_name, price FROM menu WHERE id = '$menu_id' AND user_id = '$user_id'";
    $menu_result = $conn->query($menu_query);

    if ($menu_result->num_rows > 0) {
        $menu = $menu_result->fetch_assoc();
        $menu_name = $menu['menu_name'];
        $price = $menu['price'];

        $sql = "INSERT INTO stock (menu_name, price, quantity, date_added, user_id) VALUES ('$menu_name', '$price', '$quantity', '$date_added', '$user_id')";

        if ($conn->query($sql) === TRUE) {
            header("Location: menu.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Menu not found or you do not have permission to add stock for this menu.";
    }
}

// Ambil daftar menu untuk pengguna saat ini
$user_id = $_SESSION['user_id'];
$menus_query = "SELECT id, menu_name FROM menu WHERE user_id = '$user_id'";
$menus_result = $conn->query($menus_query);

   include('templates/header.php');
    ?>

<!DOCTYPE html>
<html>
<title>Add Stock</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
      function updatePrice() {
            var menuSelect = document.getElementById('menu_id');
            var priceInput = document.getElementById('price');
            var selectedOption = menuSelect.options[menuSelect.selectedIndex];
            priceInput.value = selectedOption.getAttribute('data-price');
      }
    </script>
    <script>
        $(document).ready(function() {
            $('#menu_id').select2({
                ajax: {
                    url: 'get_menu.php',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.items
                        };
                    },
                    cache: true
                },
                placeholder: 'Search for a menu',
                minimumInputLength: 1,
            }).on('select2:select', function (e) {
                var data = e.params.data;
                $('#price').val(data.price);
            });
        });
    </script>
    </head>
<body>
    <br>
<div class="container">
    <h2>Tambah Menu</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="menu_id">Menu Name:</label>
            <select class="form-control" id="menu_id" name="menu_id" onchange="updatePrice()" required>
                <option value="">Select Menu</option>
               
                 <?php while ($menu = $menus_result->fetch_assoc()): ?>
                    <option value="<?php echo $user['id']; ?>" data-price="<?php echo $menu['price']; ?>"><?php echo $menu['menu_name']; ?></option>
                <?php endwhile; ?>
            </select>
            
                <!-- Options will be loaded via AJAX -->
            <!-- </select>type="text" class="form-control" id="menu_name" name="menu_name" required> -->
        </div>
        <div class="form-group">
            <a href="add_vmenu.php"class="btn btn-warning">TAMBAH MENU BARU</a>
            <br>
            <br>
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <div class="form-group">
            <label for="date_added">Date Added:</label>
            <input type="date" class="form-control" id="date_added" name="date_added" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
        
    </form>
</div>
</body>
</html>
