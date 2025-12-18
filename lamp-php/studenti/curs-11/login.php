<?php
session_start();

// dacă deja e logat, îl trimitem la lista de studenți
if (isset($_SESSION['user'])) {
    header('Location: administrare_studenti.php');
    exit;
}

$username = '';
$errors = [];

// user de test (DOAR pentru demo / lab)
$USER_VALID    = 'admin';
$PAROLA_VALIDA = 'parola123';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $errors[] = "Te rugăm să completezi utilizatorul și parola.";
    } else {
        if ($username === $USER_VALID && $password === $PAROLA_VALIDA) {
            // LOGIN OK → setăm sesiunea
            $_SESSION['user'] = $username;

            // redirect spre o pagină protejată (lista de studenți)
            header('Location: administrare_studenti.php');
            exit;
        } else {
            $errors[] = "Utilizator sau parolă greșite.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Login simplu</title>
    <style>
        body { font-family: system-ui, Arial, sans-serif; background:#0f172a; margin:0; }
        main { max-width:400px; margin:60px auto; background:#fff; border-radius:12px;
               padding:20px; box-shadow:0 10px 30px rgba(15,23,42,0.35); }
        h1 { margin-top:0; text-align:center; }
        label { display:block; margin-top:8px; }
        input[type="text"], input[type="password"] {
            width:100%; padding:8px; border-radius:6px;
            border:1px solid #cbd5e1; box-sizing:border-box;
        }
        button {
            width:100%; margin-top:14px; padding:10px 16px; border-radius:6px; border:none;
            background:#0ea5e9; color:#fff; cursor:pointer; font-weight:600;
        }
        button:hover { background:#0284c7; }
        .msg { padding:10px; border-radius:8px; margin-bottom:10px; }
        .msg.err { background:#fef2f2; border-left:4px solid #ef4444; }
        .muted { color:#6b7280; font-size:0.9em; text-align:center; margin-top:10px; }
        code { background:#e5e7eb; padding:2px 4px; border-radius:4px; }
    </style>
</head>
<body>
<main>
    <h1>Autentificare</h1>

    <?php if (!empty($errors)): ?>
        <div class="msg err">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="username">Utilizator:</label>
        <input type="text" id="username" name="username"
               value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="password">Parolă:</label>
        <input type="password" id="password" name="password">

        <button type="submit">Login</button>
    </form>

    <p class="muted">
        Pentru test, folosește:<br>
        user: <code><?php echo htmlspecialchars($USER_VALID, ENT_QUOTES, 'UTF-8'); ?></code>,
        parolă: <code><?php echo htmlspecialchars($PAROLA_VALIDA, ENT_QUOTES, 'UTF-8'); ?></code>
    </p>
</main>
</body>
</html>
