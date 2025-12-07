<?php
$host = 'mysql';
$user = 'user';
$pass = 'password';
$db   = 'studenti';

$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // aruncă excepții la eroare
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // fetch ca array asociativ
    PDO::ATTR_EMULATE_PREPARES   => false,                  // prepared statements reale
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
     echo "Conectare reușită!";
} catch (PDOException $e) {
    die('Conectare eșuată: ' . $e->getMessage());
}
