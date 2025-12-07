<?php
// procesare.php

// Helper pentru afișare sigură (fără XSS)
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$mesaj = '';
$detalii = '';
$tip = $_REQUEST['tip'] ?? null; // poate veni din GET sau POST

if ($tip === 'salut_get' && isset($_GET['nume'])) {
    $nume = trim($_GET['nume']);
    if ($nume === '') {
        $mesaj = "Nu ai introdus numele.";
    } else {
        $mesaj = "Salut, " . e($nume) . " (primit prin GET)!";
        $detalii = "Metodă: GET · Parametru: nume=" . e($nume);
    }
}
elseif ($tip === 'email_post' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if ($email === '') {
        $mesaj = "Nu ai introdus emailul.";
    } else {
        $mesaj = "Ai trimis emailul: " . e($email);
        $detalii = "Metodă: POST · Parametru: email=" . e($email);
    }
}
elseif ($tip === 'age_calc' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume = trim($_POST['nume'] ?? '');
    $an   = (int)($_POST['an'] ?? 0);
    $an_curent = (int)date('Y');

    if ($nume === '' || $an < 1900 || $an > $an_curent) {
        $mesaj = "Date invalide. Verifică numele și anul nașterii.";
    } else {
        $varsta = $an_curent - $an;
        $mesaj = "Salut, " . e($nume) . "! Ai aproximativ {$varsta} ani.";
        $detalii = "Metodă: POST · Parametri: nume=" . e($nume) . ", an=" . e((string)$an);
    }
} else {
    $mesaj = "Nu există o acțiune recunoscută sau acces direct fără formular.";
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Rezultat procesare formulare</title>
    <style>
        body { font-family: system-ui, Arial, sans-serif; background:#f8fafc; margin:0; }
        header, footer { background:#0f172a; color:#e5e7eb; padding:10px 20px; }
        main { max-width:700px;margin:0 auto;padding:20px; }
        .box { background:#ffffff; border:1px solid #e5e7eb; border-radius:10px; padding:16px; margin-top:16px; }
        .msg { padding:10px; border-radius:8px; margin-bottom:10px;
               background:#ecfdf5; border-left:4px solid #16a34a; }
        .muted { color:#6b7280; font-size:0.9em; }
        a.button { display:inline-block;margin-top:10px;padding:8px 16px;
                   border-radius:6px;background:#0ea5e9;color:white;text-decoration:none; }
        a.button:hover { background:#0284c7; }
        pre { background:#f3f4f6;padding:8px;border-radius:6px;overflow:auto; }
    </style>
</head>
<body>

<header>
    <h1>Rezultat procesare</h1>
</header>

<main>
    <div class="box">
        <div class="msg">
            <strong>Mesaj:</strong><br>
            <?php echo e($mesaj); ?>
        </div>

        <?php if ($detalii): ?>
            <p><strong>Detalii tehnice:</strong></p>
            <p class="muted"><?php echo e($detalii); ?></p>
        <?php endif; ?>

        <p class="muted">
            Poți vedea datele brute trimise de browser folosind <code>var_dump(\$_GET)</code> și <code>var_dump(\$_POST)</code>.
        </p>

        <h3>Debug: $_GET</h3>
        <pre><?php var_dump($_GET); ?></pre>

        <h3>Debug: $_POST</h3>
        <pre><?php var_dump($_POST); ?></pre>

        <a class="button" href="form.php">Înapoi la formulare</a>
    </div>
</main>

<footer>
    <p>&copy; 2025 – Procesare formulare PHP</p>
</footer>

</body>
</html>
