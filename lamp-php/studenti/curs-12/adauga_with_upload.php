<?php
require 'verifica_login.php';
require 'connect.php';
require 'upload_helper.php';
//require 'administrare_studenti.php';


$nume  = '';
$email = '';
$grupa = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume  = trim($_POST['nume']  ?? '');
    $email = trim($_POST['email'] ?? '');
    $grupa = trim($_POST['grupa'] ?? '');

    // validări simple
    if ($nume === '') $errors[] = "Numele este obligatoriu.";
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalid.";
    if ($grupa === '') $errors[] = "Grupa este obligatorie.";

    // upload poza (opțional)
    $upload = upload_poza_student('poza', __DIR__ . '/uploads');
    if (!$upload['ok']) {
        $errors[] = $upload['error'];
    }

    if (empty($errors)) {
        $pozaFilename = $upload['filename']; // poate fi null dacă nu s-a urcat

        $sql = "INSERT INTO studenti (nume, email, grupa, poza)
                VALUES (:nume, :email, :grupa, :poza)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nume'  => $nume,
            ':email' => $email,
            ':grupa' => $grupa,
            ':poza'  => $pozaFilename,
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
        header("Location: listare.php?succes=1");
        exit;
    }
}

//require 'header.php';
?>
<head>
<link rel="stylesheet" href="style.css">
</head>
<div class="card">
    <h2>Adaugă student</h2>

    <?php if (!empty($errors)): ?>
        <div class="msg err">
            <strong>Erori:</strong>
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="adauga_with_upload.php" enctype="multipart/form-data">
        <label for="nume">Nume:</label>
        <input type="text" id="nume" name="nume"
               value="<?php echo htmlspecialchars($nume, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"
               value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="grupa">Grupa:</label>
        <input type="text" id="grupa" name="grupa"
               value="<?php echo htmlspecialchars($grupa, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="poza">Poză student (JPG/PNG/WEBP, max 2MB):</label>
        <input type="file" id="poza" name="poza" accept="image/*">

        <button class="btn" type="submit">Salvează</button>
        <a class="btn" style="background:#6b7280" href="listare.php">Anulează</a>
    </form>
</div>

<?php //require 'footer.php'; ?>
