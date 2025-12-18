<?php
// Îl incluzi la începutul paginilor care trebuie să fie accesibile doar după login.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // nu e logat → redirect la login
	//echo "Utilizatorul nu este logat";
    header('Location: login.php');
    exit;
}
else {
	//echo " UTILIZATOR SETAT";
}
