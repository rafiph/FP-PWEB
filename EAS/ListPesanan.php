<?php
include 'config.php'; // Koneksi ke database
include 'checkLogin.php'; // Include the login check file
requireLogin(); // Make sure the user is logged in

// Handle the checkout submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id']; // Ensure user_id is sent
    $cart_items = json_decode($_POST['cart_items'], true);
    $total_harga = $_POST['total_harga'];
    $date = date('Y-m-d H:i:s');

    foreach ($cart_items as $item) {
        $makanan_id = $item['makanan_id'];
        $quantity = $item['quantity'];
        $harga = $item['harga'] * $quantity;

        // Insert into "pesanan" table
        $sql = "INSERT INTO pesanan (users_id, makanan_id, total_harga, date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iiis', $user_id, $makanan_id, $harga, $date);

        if (!$stmt->execute()) {
            die("Error: " . $stmt->error);
        }
    }

    echo "Pesanan berhasil disimpan!";
    exit;
}

// Get cart data from URL or POST
$cart = isset($_GET['cart']) ? json_decode($_GET['cart'], true) : [];

// Handle displaying "My Orders"
$orders = []; // Retrieve orders from the database (add your SQL logic to fetch orders)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Kebab Baba Kinan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #FF5733;
            color: white;
            padding: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-left img {
            margin-left: 10px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 10px; /* Space between buttons */
        }

        .logout-button, .my-order {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: white;
            color: #FF5733;
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logout-button:hover, .my-order:hover {
            background-color: #e14c2b;
            color: white;
        }

        .cart {
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        .cart h2 {
            color: #333;
        }

        .cart-items {
            list-style: none;
            padding: 0;
            margin-top: 10px;
        }

        .cart-items li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .checkout-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }

        .checkout-button:hover {
            background-color: #45a049;
        }

        #checkout-form {
            display: none;
            margin-top: 20px;
        }

        #checkout-form input[type="text"],
        #checkout-form input[type="email"] {
            padding: 8px;
            margin-top: 5px;
            width: calc(100% - 16px);
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #checkout-form button {
            background-color: #FF5733;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        #checkout-form button:hover {
            background-color: #e14c2b;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <h1>Kebab Baba Kinan</h1>
            <img src="images/babakinan.png" alt="Logo Baba Kinan" width="50" height="50">
        </div>
        <div class="header-right">
            <button class="my-order" onclick="window.location.href='myOrders.php'">My Orders</button>
            <button class="logout-button" onclick="window.location.href='Delete.php'">Delete Profile</button>
            <button class="logout-button" onclick="window.location.href='EditProfile.php'">Edit Profile</button>
            <button class="logout-button" onclick="window.location.href='Logout.php'">Logout</button>
        </div>
    </header>

    <section class="cart">
        <h2>Your Cart</h2>
        <ul class="cart-items">
            <?php
            $total = 0;
            foreach ($cart as $item) {
                $subtotal = $item['quantity'] * $item['harga'];
                $total += $subtotal;
                echo "<li>{$item['name']} - Rp {$item['harga']} x {$item['quantity']}</li>";
            }
            ?>
        </ul>
        <p>Total: Rp <span class="total-value"><?php echo $total; ?></span></p>
        <button class="checkout-button" onclick="showCheckoutForm()">Checkout</button>

        <form id="checkout-form" method="POST">
            <input type="hidden" name="user_id" value="1"> <!-- Replace with actual user_id -->
            <input type="hidden" name="cart_items" value='<?php echo json_encode($cart); ?>'>
            <input type="hidden" name="total_harga" value="<?php echo $total; ?>">

            <button type="submit">Place Order</button>
        </form>
    </section>

    <footer>
        <p>Instagram: @Kebab_Baba_Kinan</p>
    </footer>

    <script>
        function showCheckoutForm() {
            document.getElementById('checkout-form').style.display = 'block';
        }
    </script>
</body>
</html>
