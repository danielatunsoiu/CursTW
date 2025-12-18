<?php
// seed_admin.php – rulează o singură dată ca să creezi utilizatorul admin

require 'connect.php';

$username = 'admin_superior';
$email    = 'admin@example.com';
$parola   = 'parola123'; // parola în clar DOAR aici în script, nu o stocăm în DB

$parola_hash = password_hash($parola, PASSWORD_DEFAULT);

$sql = "INSERT INTO utilizatori (username, email, parola_hash, rol)
        VALUES (:u, :e, :p, :r)";

$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ':u' => $username,
        ':e' => $email,
        ':p' => $parola_hash,
        ':r' => 'admin',
    ]);
    echo "Utilizatorul admin a fost creat cu succes!";
} catch (PDOException $e) {
    echo "Eroare la inserare: " . $e->getMessage();
}

