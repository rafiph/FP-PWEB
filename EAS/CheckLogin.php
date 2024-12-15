<?php
session_start(); // Start the session if not already started

/**
 * Check if the user is logged in.
 *
 * @return bool True if the user is logged in, False otherwise.
 */
function isUserLoggedIn(): bool {
    return isset($_SESSION['user_id']); // Adjust 'user_id' to your session variable
}

/**
 * Redirect to login page if user is not logged in.
 *
 * @param string $redirectTo The URL to redirect to (default: "Login.php").
 */
function requireLogin(string $redirectTo = "Landing.php") {
    if (!isUserLoggedIn()) {
        header("Location: $redirectTo");
        exit();
    }
}
?>
