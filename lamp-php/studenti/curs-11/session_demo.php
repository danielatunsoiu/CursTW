<?php
session_start();
//daca dam reset
if (isset($_GET['reset']) && $_GET['reset'] === '1') {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
    header('Location: session_demo.php');
    exit;
}

// inițializează un contor de vizite în sesiune
if (!isset($_SESSION['vizite'])) {
    $_SESSION['vizite'] = 0;
}
$_SESSION['vizite']++;

// dacă s-a trimis formularul cu numele
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nume'])) {
    $nume = trim($_POST['nume']);
    if ($nume !== '') {
        $_SESSION['nume'] = $nume;
    }
}

// dacă s-a cerut resetarea sesiunii
if (isset($_GET['reset']) && $_GET['reset'] === '1') {
    // ștergem toate datele din sesiune
    session_unset();
    session_destroy();
    // recreăm o sesiune curată (opțional) și redirecționăm
    header('Location: session_demo.php');
    exit;
}

$nume_salvat = $_SESSION['nume'] ?? null;
$vizite = $_SESSION['vizite'] ?? 1;
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Demo sesiuni PHP</title>
    <style>
        body { font-family: system-ui, Arial, sans-serif; background:#f8fafc; margin:0; }
        main { max-width:600px; margin:40px auto; background:#fff; border-radius:10px;
               border:1px solid #e5e7eb; padding:20px; }
        h1 { margin-top:0; }
        .msg { padding:10px; border-radius:8px; margin-bottom:10px; }
        .msg.info { background:#eff6ff; border-left:4px solid #3b82f6; }
        label { display:block; margin-top:8px; }
        input[type="text"] { width:100%; padding:8px; border-radius:6px;
                             border:1px solid #cbd5e1; box-sizing:border-box; }
        button, a.button {
            display:inline-block; margin-top:10px; padding:8px 16px; border-radius:6px;
            border:none; background:#0ea5e9; color:white; text-decoration:none; cursor:pointer;
        }
        a.button.reset { background:#ef4444; }
    </style>
</head>
<body>
<main>
    <h1>Demo sesiuni PHP</h1>

    <div class="msg info">
        <strong>Vizite:</strong> Ai încărcat această pagină de
        <strong><?php echo (int)$vizite; ?></strong> ori în această sesiune.
    </div>

    <?php if ($nume_salvat): ?>
        <p>Salut, <strong><?php echo htmlspecialchars($nume_salvat, ENT_QUOTES, 'UTF-8'); ?></strong>! 👋</p>
    <?php else: ?>
        <p>Nu ai setat încă un nume în sesiune.</p>
    <?php endif; ?>

	<p>Session ID curent: <code><?php echo session_id(); ?></code></p>


    <form method="POST" action="session_demo.php">
        <label for="nume">Setează numele în sesiune:</label>
        <input type="text" id="nume" name="nume" placeholder="Ex: Ana" />
        <button type="submit">Salvează în sesiune</button>
    </form>

    <p>
        <a class="button reset" href="session_demo.php?reset=1"
           onclick="return confirm('Sigur vrei să resetezi sesiunea?');">
           Resetează sesiunea
        </a>
    </p>

    <p style="font-size:0.9em;color:#6b7280;">
        Observă cum, dacă reîncarci pagina (F5), contorul crește.  
        Dacă deschizi pagina în alt browser/incognito, sesiunea este alta (alt utilizator).
    </p>
</main>
</body>
</html>
