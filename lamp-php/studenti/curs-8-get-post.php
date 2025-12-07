<?php

// Pentru mini-agenda: date inițiale (în mod normal ar veni din DB)
$agenda = [
    ['nume' => 'Ana Pop', 'telefon' => '0712345678'],
    ['nume' => 'Ion Ionescu', 'telefon' => '0722334455'],
];

// Dacă s-a trimis formularul de adăugare contact (mini-agendă)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agenda_submit'])) {
    $nume_nou = trim($_POST['agenda_nume'] ?? '');
    $tel_nou  = trim($_POST['agenda_tel'] ?? '');

    if ($nume_nou !== '' && $tel_nou !== '') {
        // Adăugăm în array-ul din memorie (NU e persistent între request-uri)
        $agenda[] = [
            'nume'    => $nume_nou,
            'telefon' => $tel_nou,
        ];
        $agenda_msg = "Contact adăugat (doar în memoria scriptului, fără DB).";
    } else {
        $agenda_err = "Te rugăm să introduci numele și telefonul.";
    }
}

// Pentru calculator vârstă (mini-proiect 1)
$rezultat_varsta = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['age_submit'])) {
    $nume_age = trim($_POST['age_nume'] ?? '');
    $an_nastere = (int)($_POST['age_an'] ?? 0);
    $an_curent = (int)date('Y');

    if ($nume_age !== '' && $an_nastere > 1900 && $an_nastere <= $an_curent) {
        $varsta = $an_curent - $an_nastere;
        $rezultat_varsta = "Salut, " . htmlspecialchars($nume_age) . "! Ai aproximativ {$varsta} ani.";
    } else {
        $rezultat_varsta = "Date invalide. Verifică numele și anul nașterii.";
    }
}

// Pentru exercițiul cu GET – salut cu nume
$salut_get = null;
if (isset($_GET['nume_get']) && $_GET['nume_get'] !== '') {
    $salut_get = "Salut, " . htmlspecialchars($_GET['nume_get']) . " (primit prin GET)!";
}

// Pentru exercițiul cu POST – email simplu
$email_msg = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_submit'])) {
    $email = trim($_POST['email'] ?? '');
    if ($email !== '') {
        $email_msg = "Ai trimis emailul: " . htmlspecialchars($email);
    } else {
        $email_msg = "Te rugăm să introduci un email.";
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Curs PHP – Exerciții GET & POST + Mini-proiecte</title>
    <style>
        body { font-family: system-ui, Arial, sans-serif; background:#f8fafc; margin:0; }
        header, footer { background:#0f172a; color:#e5e7eb; padding:10px 20px; }
        main { max-width: 1000px; margin:0 auto; padding:20px; }
        h1, h2, h3 { margin-top:0; }
        section { background:#ffffff; border:1px solid #e5e7eb; border-radius:10px; padding:16px; margin-bottom:16px; }
        nav a { color:#e5e7eb; margin-right:10px; text-decoration:none; }
        nav a:hover { text-decoration:underline; }
        label { display:block; margin-top:8px; }
        input[type="text"], input[type="number"], input[type="email"], textarea {
            width:100%; padding:8px; border-radius:6px; border:1px solid #cbd5e1; box-sizing:border-box;
        }
        button { margin-top:10px; padding:8px 16px; border-radius:6px; border:none; cursor:pointer; background:#0ea5e9; color:white; }
        button:hover { background:#0284c7; }
        .msg { margin-top:10px; padding:10px; border-radius:8px; }
        .msg.ok { background:#ecfdf5; border-left:4px solid #16a34a; }
        .msg.err { background:#fef2f2; border-left:4px solid #ef4444; }
        table { border-collapse: collapse; width:100%; margin-top:10px; }
        th, td { border:1px solid #e5e7eb; padding:8px; text-align:left; }
        th { background:#f1f5f9; }
        .muted { color:#6b7280; font-size:0.9em; }
    </style>
</head>
<body>

<header>
    <h1>Curs PHP – Exerciții cu GET & POST + Mini-proiecte</h1>
    <nav>
        <a href="#ex-get">Exercițiu GET</a>
        <a href="#ex-post">Exercițiu POST</a>
        <a href="#mini-age">Mini-proiect: vârstă</a>
        <a href="#mini-agenda">Mini-proiect: agendă</a>
    </nav>
</header>

<main>

    <!-- ======================= EXERCIȚIU 1 – GET ======================= -->
    <section id="ex-get">
        <h2>Exercițiu 1 – Formular simplu cu GET</h2>
        <p class="muted">
            Cerință: Creează un formular care trimite numele prin <code>GET</code> și afișează un mesaj de salut.
        </p>

        <form method="GET" action="#ex-get">
            <label for="nume_get">Nume:</label>
            <input type="text" name="nume_get" id="nume_get" placeholder="Introdu numele tău" />
            <button type="submit">Trimite (GET)</button>
        </form>

        <?php if ($salut_get !== null): ?>
            <div class="msg ok">
                <?php echo $salut_get; ?>
            </div>
        <?php endif; ?>

        <p class="muted">
            Observație: Uită-te în bara de adrese – vezi parametrii de tip <code>?nume_get=...</code>.
        </p>
    </section>

    <!-- ======================= EXERCIȚIU 2 – POST ======================= -->
    <section id="ex-post">
        <h2>Exercițiu 2 – Formular simplu cu POST</h2>
        <p class="muted">
            Cerință: Creează un formular care trimite un email prin <code>POST</code> și afișează ce s-a trimis.
        </p>

        <form method="POST" action="#ex-post">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="email@exemplu.ro" />
            <button type="submit" name="email_submit">Trimite (POST)</button>
        </form>

        <?php if ($email_msg !== null): ?>
            <div class="msg ok">
                <?php echo htmlspecialchars($email_msg); ?>
            </div>
        <?php endif; ?>

        <p class="muted">
            Observație: La <code>POST</code>, datele NU apar în URL. Pot fi vizualizate cu <code>$_POST</code> pe server.
        </p>
    </section>

    <!-- ================== MINI-PROIECT 1 – CALCULATOR VÂRSTĂ ================== -->
    <section id="mini-age">
        <h2>Mini-proiect 1 – Calculator de vârstă</h2>
        <p class="muted">
            Cerință: Creează un formular cu nume + an naștere. La trimitere (POST), calculează vârsta și afișează:
            <br><code>„Salut, X, ai Y ani.”</code>
        </p>

        <form method="POST" action="#mini-age">
            <label for="age_nume">Nume:</label>
            <input type="text" name="age_nume" id="age_nume" placeholder="Numele tău" />

            <label for="age_an">An naștere:</label>
            <input type="number" name="age_an" id="age_an" placeholder="1999" />

            <button type="submit" name="age_submit">Calculează vârsta</button>
        </form>

        <?php if ($rezultat_varsta !== null): ?>
            <div class="msg ok">
                <?php echo htmlspecialchars($rezultat_varsta); ?>
            </div>
        <?php endif; ?>

        <p class="muted">
            Rezolvare (logică): <code>$varsta = an_curent - an_nastere;</code> și afișare cu <code>echo</code>.
        </p>
    </section>

    <!-- ================== MINI-PROIECT 2 – MINI-AGENDA (FĂRĂ DB) ================== -->
    <section id="mini-agenda">
        <h2>Mini-proiect 2 – Mini-agendă (fără DB)</h2>
        <p class="muted">
            Cerință: Ai o agendă (array de contacte). Afișează contactele într-un tabel și permite adăugarea
            unui contact nou printr-un formular <code>POST</code>.
        </p>

        <h3>Contacte existente (în array)</h3>
        <?php if (!empty($agenda)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nume</th>
                        <th>Telefon</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agenda as $contact): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['nume']); ?></td>
                            <td><?php echo htmlspecialchars($contact['telefon']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="msg err">Nu există contacte.</div>
        <?php endif; ?>

        <h3>Adaugă un contact nou</h3>
        <form method="POST" action="#mini-agenda">
            <label for="agenda_nume">Nume:</label>
            <input type="text" name="agenda_nume" id="agenda_nume" placeholder="Nume contact" />

            <label for="agenda_tel">Telefon:</label>
            <input type="text" name="agenda_tel" id="agenda_tel" placeholder="07..." />

            <button type="submit" name="agenda_submit">Adaugă</button>
        </form>

        <?php if (isset($agenda_msg)): ?>
            <div class="msg ok">
                <?php echo htmlspecialchars($agenda_msg); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($agenda_err)): ?>
            <div class="msg err">
                <?php echo htmlspecialchars($agenda_err); ?>
            </div>
        <?php endif; ?>

        <p class="muted">
            Notă: Agenda este ținută în memorie (array PHP), <strong>fără bază de date</strong>.
            La fiecare refresh complet al paginii, se va reseta la valorile inițiale.
        </p>
    </section>

</main>

<footer>
    <p>&copy; 2025 – Exerciții PHP GET & POST · Mini-proiecte</p>
</footer>

</body>
</html>
