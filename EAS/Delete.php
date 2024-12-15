<?php
include 'config.php';
include 'checkLogin.php'; // Include the login check file
requireLogin();

// Proses data form
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete_account"])) {
        // Hapus data berdasarkan username dari session
        $username = $_SESSION['username'];

        // Cari ID pengguna
        $queryUser = "SELECT id FROM users WHERE username = ?";
        $stmtUser = $conn->prepare($queryUser);
        $stmtUser->bind_param("s", $username);
        $stmtUser->execute();
        $result = $stmtUser->get_result();
        $user = $result->fetch_assoc();
        $userId = $user['id'];
        $stmtUser->close();

        // Hapus data terkait di tabel pesanan
        $queryDeletePesanan = "DELETE FROM pesanan WHERE users_id = ?";
        $stmtPesanan = $conn->prepare($queryDeletePesanan);
        $stmtPesanan->bind_param("i", $userId);
        $stmtPesanan->execute();
        $stmtPesanan->close();

        // Hapus data pengguna
        $queryDeleteUser = "DELETE FROM users WHERE id = ?";
        $stmtUserDelete = $conn->prepare($queryDeleteUser);
        $stmtUserDelete->bind_param("i", $userId);

        if ($stmtUserDelete->execute()) {
            $message = "Akun Anda telah dihapus.";
            session_destroy(); // Hapus session setelah akun dihapus
        } else {
            $message = "Terjadi kesalahan: " . $stmtUserDelete->error;
        }

        $stmtUserDelete->close();
    }
}

// Tutup koneksi
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account - Kebab Baba Kinan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .delete-container {
            background-color: white;
            padding: 20px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #FF5733;
        }
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
        }
        .delete-button {
            background-color: #FF5733;
            color: white;
        }
        .delete-button:hover {
            background-color: #e14c2b;
        }
        .cancel-button {
            background-color: #ccc;
            color: black;
        }
        .cancel-button:hover {
            background-color: #bbb;
        }
        .success-message {
            color: green;
            font-weight: bold;
        }
        .menu-container {
            margin-top: 20px;
        }
        .menu-container a {
            display: inline-block;
            margin: 5px 10px;
            padding: 10px 15px;
            color: white;
            background-color: #FF5733;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }
        .menu-container a:hover {
            background-color: #e14c2b;
        }
    </style>
</head>
<body>
    <div class="delete-container">
        <h2>Hapus Akun</h2>

        <?php if ($message): ?>
            <p class="success-message"><?= htmlspecialchars($message) ?></p>
            <div class="menu-container">
                <button onclick="window.location.href='Logout.php'">Logout</button>
            </div>
        <?php else: ?>
            <p>Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.</p>
            <form action="" method="POST">
                <button type="submit" name="delete_account" class="delete-button">Hapus Akun</button>
                <button type="button" class="cancel-button" onclick="window.location.href='Menu.php'">Kembali</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
