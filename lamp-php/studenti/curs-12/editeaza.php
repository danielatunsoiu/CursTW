<?php
require 'verifica_login.php';
require 'connect.php';
require 'upload_helper.php';
require 'administrare_studenti.php';
//http://localhost:8080/curs-12/editeaza.php?id=5

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) die("ID invalid.");

// citim studentul
$stmt = $pdo->prepare("SELECT id, nume, email, grupa, poza FROM studenti WHERE id = :id");
$stmt->execute([':id' => $id]);
$student = $stmt->fetch();
if (!$student) die("Student inexistent.");

$nume  = $student['nume'];
$email = $student['email'];
$grupa = $student['grupa'];
$poza_veche = $student['poza'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nume  = trim($_POST['nume']  ?? '');
    $email = trim($_POST['email'] ?? '');
    $grupa = trim($_POST['grupa'] ?? '');

    if ($nume === '') $errors[] = "Numele este obligatoriu.";
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalid.";
    if ($grupa === '') $errors[] = "Grupa este obligatorie.";

    // upload nou (opțional)
    $upload = upload_poza_student('poza', __DIR__ . '/uploads');
    if (!$upload['ok']) {
        $errors[] = $upload['error'];
    }

    if (empty($errors)) {
        $pozaNoua = $poza_veche;

        if ($upload['filename'] !== null) {
            $pozaNoua = $upload['filename'];

            // opțional: ștergem poza veche
            if ($poza_veche) {
                $oldPath = __DIR__ . '/uploads/' . $poza_veche;
                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }

        $stmt = $pdo->prepare("
            UPDATE studenti
            SET nume = :nume, email = :email, grupa = :grupa, poza = :poza
            WHERE id = :id
        ");
        $stmt->execute([
            ':nume'  => $nume,
            ':email' => $email,
            ':grupa' => $grupa,
            ':poza'  => $pozaNoua,
            ':id'    => $id,
        ]);

        header("Location: listare.php?succes=2");
        exit;
    }
}

//require 'header.php';
?>
<div class="card">
    <h2>Editează student (ID: <?php echo (int)$id; ?>)</h2>

    <?php if (!empty($errors)): ?>
        <div class="msg err"><ul>
            <?php foreach ($errors as $e): ?><li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li><?php endforeach; ?>
        </ul></div>
    <?php endif; ?>

    <?php if ($poza_veche): ?>
        <p>Poză curentă:</p>
        <img src="uploads/<?php echo htmlspecialchars($poza_veche, ENT_QUOTES, 'UTF-8'); ?>"
             alt="Poza student" style="max-width:160px;border-radius:10px;">
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" action="editeaza.php?id=<?php echo (int)$id; ?>">
        <label>Nume:</label>
        <input type="text" name="nume" value="<?php echo htmlspecialchars($nume, ENT_QUOTES, 'UTF-8'); ?>">

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">

        <label>Grupa:</label>
        <input type="text" name="grupa" value="<?php echo htmlspecialchars($grupa, ENT_QUOTES, 'UTF-8'); ?>">

        <label>Poză nouă (opțional):</label>
        <input type="file" name="poza" accept="image/*">

        <button class="btn" type="submit">Salvează</button>
        <a class="btn" style="background:#6b7280" href="listare.php">Anulează</a>
    </form>
</div>
<?php //require 'footer.php'; ?>
