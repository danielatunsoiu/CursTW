<?php
require 'verifica_login.php';

if (($_SESSION['rol'] ?? '') !== 'admin') {
    // nu este admin -> îl dai afară sau afișezi mesaj
    header('Location: logout.php');
    exit;
}
require 'connect.php';

		
// inițializăm variabilele pentru repopulare formular în caz de eroare
$nume  = '';
$email = '';
$grupa = '';
$errors = [];

// dacă formularul a fost trimis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume  = trim($_POST['nume']  ?? '');
    $email = trim($_POST['email'] ?? '');
    $grupa = trim($_POST['grupa'] ?? '');

    // validări simple
    if ($nume === '') {
        $errors[] = "Numele este obligatoriu.";
    }
    if ($email === '') {
        $errors[] = "Emailul este obligatoriu.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Emailul nu este valid.";
    }
    if ($grupa === '') {
        $errors[] = "Grupa este obligatorie.";
    }

    // dacă nu avem erori, inserăm în DB
    if (empty($errors)) {
        $sql = "INSERT INTO studenti (nume, email, grupa) VALUES (:nume, :email, :grupa)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nume'  => $nume,
            ':email' => $email,
            ':grupa' => $grupa,
        ]);
	$logDir = __DIR__ . '/storage';
	$logFile = $logDir . '/audit.log';

	if (!is_dir($logDir)) {
		mkdir($logDir, 0755, true);
	}

	$username = $_SESSION['username'] ?? 'unknown';
	file_put_contents(__DIR__.'/storage/audit.log',
	"[".date('Y-m-d H:i:s')."] user=".$_SESSION['username']." action=ADD student=".$nume.PHP_EOL,
	FILE_APPEND | LOCK_EX
);
        // redirect cu mesaj de succes
        header("Location: listare.php?succes=1");
        exit;
    }
}

require 'administrare_studenti.php';
?>

<div class="card">
    <h2>Adaugă student</h2>

    <?php if (!empty($errors)): ?>
        <div class="msg err">
            <strong>Au apărut erori:</strong>
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="adauga.php">
        <label for="nume">Nume:</label>
        <input type="text" id="nume" name="nume" value="<?php echo htmlspecialchars($nume, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="grupa">Grupa:</label>
        <input type="text" id="grupa" name="grupa" value="<?php echo htmlspecialchars($grupa, ENT_QUOTES, 'UTF-8'); ?>">

        <button class="btn" type="submit">Salvează</button>
    </form>
</div>

<?php
//require 'footer.php';