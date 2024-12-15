<?php
include 'config.php'; 
include 'checkLogin.php'; 
requireLogin(); 

$user_id = $_SESSION['user_id']; 

$sql = "SELECT p.id AS order_id, m.nama_makanan, p.total_harga, p.date, p.users_id, p.makanan_id 
        FROM pesanan p 
        JOIN makanan m ON p.makanan_id = m.id
        WHERE p.users_id = ? ORDER BY p.id ASC ";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Kebab Baba Kinan</title>
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
            gap: 10px;
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

        .orders {
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        .orders h2 {
            color: #333;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th, .orders-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .orders-table th {
            background-color: #FF5733;
            color: white;
        }

        .orders-table td {
            background-color: #f9f9f9;
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
            <button class="logout-button" onclick="window.location.href='Logout.php'">Logout</button>
        </div>
    </header>

    <section class="orders">
        <h2>Your Order History</h2>

        <?php if (empty($orders)): ?>
            <p>You have no past orders yet.</p>
        <?php else: ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Item Name</th>
                        <th>Total Price</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo $order['order_id']; ?></td>
                            <td><?php echo $order['nama_makanan']; ?></td>
                            <td>Rp <?php echo number_format($order['total_harga'], 0, ',', '.'); ?></td>
                            <td><?php echo date('d-m-Y H:i', strtotime($order['date'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <footer>
        <p>Instagram: @Kebab_Baba_Kinan</p>
    </footer>
</body>
</html>
