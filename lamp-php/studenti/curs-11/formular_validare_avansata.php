<?php


// inițializăm variabilele (pentru sticky form)
$nume   = '';
$email  = '';
$grupa  = '';
$varsta = '';
$mesaj  = '';
$errors = [];
$succes = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Citim și curățăm datele
    $nume   = trim($_POST['nume']   ?? '');
    $email  = trim($_POST['email']  ?? '');
    $grupa  = trim($_POST['grupa']  ?? '');
    $varsta = trim($_POST['varsta'] ?? '');
    $mesaj_raw = $_POST['mesaj']    ?? '';
    $mesaj  = trim(strip_tags($mesaj_raw));

    // 2. Validări

    // Nume: obligatoriu, minim 3 caractere
    if ($nume === '') {
        $errors[] = "Numele este obligatoriu.";
    } elseif (mb_strlen($nume) < 3) {
        $errors[] = "Numele trebuie să aibă cel puțin 3 caractere.";
    }

    // Email: obligatoriu + format valid
    if ($email === '') {
        $errors[] = "Emailul este obligatoriu.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Emailul nu este valid.";
    }

    // Grupa: obligatorie, format gen '3A', '10B'
    if ($grupa === '') {
        $errors[] = "Grupa este obligatorie.";
    } elseif (!preg_match('/^[0-9]{1,2}[A-Z]$/', $grupa)) {
        $errors[] = "Grupa trebuie să fie de forma '3A', '10B', '12C' etc.";
    }
	//^ / $ – început/sfârșit string; [0-9]{1,2} – 1 sau 2 cifre; [A-Z] – o literă mare

    // Vârsta: opțională, dar dacă e completată → între 18 și 99
    if ($varsta !== '') {
        $varsta_int = filter_var($varsta, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 18, 'max_range' => 99]
        ]);
        if ($varsta_int === false) {
            $errors[] = "Vârsta trebuie să fie un număr între 18 și 99 (sau lasă gol).";
        }
    }

    // Mesaj: opțional, doar l-am curățat cu strip_tags

    // 3. Dacă nu avem erori → procesăm (de ex. salvăm în DB, trimitem email etc.)
    if (empty($errors)) {
        // aici ai avea de ex: INSERT în baza de date
        // pentru demo, doar marcăm succesul
        $succes = true;

        // poți reseta câmpurile dacă vrei formular „gol” după succes:
        // $nume = $email = $grupa = $varsta = $mesaj = '';
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Formular cu validare avansată (PHP)</title>
    <style>
        body { font-family: system-ui, Arial, sans-serif; background:#f8fafc; margin:0; }
        main { max-width:700px; margin:40px auto; background:#fff; border-radius:10px;
               border:1px solid #e5e7eb; padding:20px; }
        h1 { margin-top:0; }
        label { display:block; margin-top:8px; }
        input[type="text"], input[type="email"], textarea {
            width:100%; padding:8px; border-radius:6px;
            border:1px solid #cbd5e1; box-sizing:border-box;
        }
        textarea { resize:vertical; min-height:80px; }
        button { margin-top:12px; padding:8px 16px; border-radius:6px; border:none;
                 background:#0ea5e9; color:#fff; cursor:pointer; }
        button:hover { background:#0284c7; }
        .msg { padding:10px; border-radius:8px; margin-bottom:10px; }
        .msg.err { background:#fef2f2; border-left:4px solid #ef4444; }
        .msg.ok { background:#ecfdf5; border-left:4px solid #16a34a; }
        ul { margin:0 0 0 20px; }
        .muted { color:#6b7280; font-size:0.9em; }
    </style>
</head>
<body>
<main>
    <h1>Formular cu validare pe server (PHP)</h1>
    <p class="muted">
        Exemplu de: <code>trim()</code>, <code>strip_tags()</code>, <code>filter_var()</code>, <code>preg_match()</code>,
        gestionarea erorilor și “sticky form”.
    </p>

    <?php if (!empty($errors)): ?>
        <div class="msg err">
            <strong>Au apărut erori:</strong>
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($succes): ?>
        <div class="msg ok">
            Datele sunt valide ✅ Poți aici să le salvezi în baza de date sau să trimiți un email.
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nume">Nume (obligatoriu, min 3 caractere):</label>
        <input type="text" id="nume" name="nume"
               value="<?php echo htmlspecialchars($nume, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="email">Email (obligatoriu, format valid):</label>
        <input type="email" id="email" name="email"
               value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="grupa">Grupa (obligatoriu, ex: 3A, 10B):</label>
        <input type="text" id="grupa" name="grupa"
               value="<?php echo htmlspecialchars($grupa, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="varsta">Vârsta (opțional, 18–99):</label>
        <input type="text" id="varsta" name="varsta"
               value="<?php echo htmlspecialchars($varsta, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="mesaj">Mesaj (opțional):</label>
        <textarea id="mesaj" name="mesaj"><?php
            echo htmlspecialchars($mesaj, ENT_QUOTES, 'UTF-8');
        ?></textarea>

        <button type="submit">Trimite</button>
    </form>
</main>
</body>
</html>
