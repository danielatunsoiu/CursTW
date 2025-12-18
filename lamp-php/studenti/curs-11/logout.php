<?php
// logout.php
session_start();

// golește toate variabilele din sesiune
session_unset();

// distruge sesiunea
session_destroy();

// șterge cookie-ul de sesiune (opțional, dar elegant)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// redirect la login
header('Location: login.php');
exit;
