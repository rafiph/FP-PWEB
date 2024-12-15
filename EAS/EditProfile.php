<?php
include 'config.php';
include 'checkLogin.php'; // Include the login check file
requireLogin();

// Proses data form
$message = "";
$userData = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["load_profile"])) {
        // Ambil data berdasarkan username
        $username = $_POST["username"];

        $query = "SELECT name, username, phone FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $userData = $result->fetch_assoc();
        } else {
            $message = "Username tidak ditemukan.";
        }

        $stmt->close();
    } elseif (isset($_POST["update_profile"])) {
        // Proses update data
        $name = $_POST["name"];
        $username = $_POST["username"];
        $phone = $_POST["phone"];

        $updateQuery = "UPDATE users SET name = ?, phone = ? WHERE username = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sss", $name, $phone, $username);

        if ($stmt->execute()) {
            $message = "Profil berhasil diperbarui!";
        } else {
            $message = "Terjadi kesalahan: " . $stmt->error;
        }

        $stmt->close();
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
    <title>Edit Profile - Kebab Baba Kinan</title>
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
        .login-container {
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
        label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #FF5733;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #e14c2b;
        }
        .error-message {
            color: red;
            font-weight: bold;
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
    <div class="login-container">
        <h2>Edit Profile</h2>

        <?php if (!$userData): ?>
            <!-- Form untuk mengambil data pengguna -->
            <form action="" method="POST">
                <label for="username">Masukkan Username</label>
                <input type="text" id="username" name="username" required>

                <button type="submit" name="load_profile">Load Profile</button>
            </form>
        <?php else: ?>
            <!-- Form untuk mengedit data pengguna -->
            <form action="" method="POST">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required>

                <label for="username">Username (tidak dapat diubah)</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($userData['username']) ?>" readonly>

                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($userData['phone']) ?>" required>

                <button type="submit" name="update_profile">Update Profile</button>
            </form>
        <?php endif; ?>

        <?php if ($message): ?>
            <p class="<?= strpos($message, 'berhasil') !== false ? 'success-message' : 'error-message' ?>">
                <?= htmlspecialchars($message) ?>
            </p>
            <?php if (strpos($message, 'berhasil') !== false): ?>
                <div class="menu-container">
                    <button onclick="window.location.href='Menu.php'">Menu</a>
                    <button class="logout-button" onclick="window.location.href='Logout.php'">Logout</button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
