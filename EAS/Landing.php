<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebab Baba Kinan</title>
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

.logout-button {
    background-color: white;
    color: #FF5733;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.logout-button:hover {
    background-color: #e14c2b;
    color: white;
}


h1 {
    margin: 0;
}

.menu {
    padding: 20px;
    margin-bottom: 100px; 
}

.menu h2 {
    text-align: center;
    color: #333;
}

.menu-item {
    display: flex;
    background-color: white;
    margin: 20px 0;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.menu-item img {
    width: 150px;
    height: 150px;
    border-radius: 10px;
    margin-right: 20px;
}

.menu-details h3 {
    margin: 0;
    color: #FF5733;
}

.menu-details p {
    color: #555;
}

.quantity-control {
    margin-left: 900px;
    margin-top: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-control button {
    background-color: #FF5733;
    color: white;
    border: none;
    padding: 5px 15px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}

.quantity-control button:hover {
    background-color: #e14c2b;
}

.quantity {
    font-size: 18px;
    font-weight: bold;
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

.order-button-container {
    text-align: center;
    margin-top: 20px;
}

.order-button {
    background-color: #FF5733;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 18px;
    cursor: pointer;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.order-button:hover {
    background-color: #e14c2b;
}

/* Bagian utama untuk banner */
.main-banner {
    display: flex;
    flex-direction: column; /* Align items vertically (image above text) */
    align-items: center; /* Center items horizontally */
    justify-content: center; /* Center items vertically */
    background-color: white; /* Background color */
    height: 55vh; /* Full viewport height */
    color: #FF5733; /* Text color */
    margin: 0; /* Remove any default margin */
    text-align: center; /* Center-align text */
}

.main-banner .banner-text img {
    margin-bottom: 20px; /* Add space below the image */
}

.main-banner .banner-text h1 {
    font-size: 3rem; /* Adjust font size */
    font-weight: bold; /* Make text bold */
    margin: 0; /* Remove margin around heading */
}


/* Tombol Login dan Sign Up */
.auth-buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 40px 0;
}

.auth-button {
    background-color: #FF5733;
    color: white;
    border: none;
    padding: 15px 30px;
    font-size: 18px;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.auth-button:hover {
    background-color: #e14c2b;
}
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <h1>Kebab Baba Kinan</h1>
            <img src="images/babakinan.png" alt="Logo Baba Kinan" width="50" height="50">
        </div>
    </header>

    <section class="main-banner">
        <div class="banner-text">
            <img src="images/babakinan.png" alt="Logo Baba Kinan" width="200" height="200">
            <h1>Kebab Baba Kinan</h1>
        </div>
    </section>

    <section class="auth-buttons">
        <button class="auth-button login-button" onclick="window.location.href='Login.php';">Login</button>
        <button class="auth-button signup-button" onclick="window.location.href='SignUp.php';">Sign Up</button>
    </section>    

    <footer>
        <p>Instagram: @Kebab_Baba_Kinan</p>
    </footer>
</body>
</html>
