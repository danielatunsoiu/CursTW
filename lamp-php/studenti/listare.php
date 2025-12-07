<?php
require 'connect.php';
require 'administrare_studenti.php';

// citim studenții din DB
$stmt = $pdo->query("SELECT id, nume, email, grupa, created_at FROM studenti ORDER BY created_at DESC");
$studenti = $stmt->fetchAll();

// mesaj de succes (după redirect din adauga.php)
$succes = isset($_GET['succes']) ? $_GET['succes'] : null;
?>

<div class="card">
    <h2>Listare studenți</h2>

    <?php if ($succes === '1'): ?>
        <div class="msg ok">Student adăugat cu succes!</div>
    <?php endif; ?>

    <?php if (empty($studenti)): ?>
        <p>Nu există încă studenți în baza de date.</p>
        <a class="btn" href="adauga.php">Adaugă primul student</a>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nume</th>
                    <th>Email</th>
                    <th>Grupa</th>
                    <th>Creat la</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($studenti as $s): ?>
                    <tr>
                        <td><?php echo (int)$s['id']; ?></td>
                        <td><?php echo htmlspecialchars($s['nume'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($s['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($s['grupa'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($s['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><a class="btn" href="adauga.php">Adaugă un student nou</a></p>
    <?php endif; ?>
</div>

<?php
require 'footer.php';