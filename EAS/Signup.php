<?php
include 'config.php';

// Proses data form
$message = "";
$showLoginForm = false;  // Variabel untuk menampilkan form login

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Enkripsi password
    $phone = $_POST["phone"];

    // Cek apakah username sudah ada
    $checkQuery = "SELECT id FROM users WHERE username = ?";
    $stmtCheck = $conn->prepare($checkQuery);
    $stmtCheck->bind_param("s", $username);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        // Username sudah ada
        $message = "Username sudah terdaftar. Silakan pilih username lain.";
    } else {
        // Query untuk menyimpan data ke tabel `users`
        $sql = "INSERT INTO users (name, username, password, phone, date) VALUES (?, ?, ?, ?, NOW())";

        // Persiapan statement
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameter
            $stmt->bind_param("ssss", $name, $username, $password, $phone);

            // Eksekusi statement
            if ($stmt->execute()) {
                $message = "Pendaftaran berhasil!";
                $showLoginForm = true; // Menampilkan form login setelah pendaftaran berhasil
            } else {
                $message = "Terjadi kesalahan: " . $stmt->error;
            }

            // Tutup statement
            $stmt->close();
        } else {
            $message = "Terjadi kesalahan dalam persiapan statement: " . $conn->error;
        }
    }

    // Tutup statement pengecekan
    $stmtCheck->close();
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Kebab Baba Kinan</title>
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
        input[type="password"],
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
        .login-link {
            margin-top: 10px;
            font-size: 14px;
            color: #FF5733;
        }
        .login-link a {
            color: #FF5733;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Sign Up</h2>
        <form action="" method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" required>

            <button type="submit">Sign Up</button>
        </form>

        <?php if ($message): ?>
            <p class="<?= strpos($message, 'berhasil') !== false ? 'success-message' : 'error-message' ?>">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <!-- Tampilkan form login jika pendaftaran berhasil -->
        <?php if ($showLoginForm): ?>
            <div class="login-link">
                <p>Sudah memiliki akun? <a href="login.php">Login di sini</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
