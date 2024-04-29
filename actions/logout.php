<?php
session_start(); 

// Unset all of the session variables.
$_SESSION = [];


// This will destroy the session, and cookies if "on".
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

// Redirect to the index page after logging out, all users even guests can view.
header("Location: /index.php");
exit;
?>
