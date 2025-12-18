<?php
session_start();

// dacă nu avem număr în sesiune → generăm unul
if (!isset($_SESSION['numar'])) {
    $_SESSION['numar'] = rand(1, 20); // joc simplu 1–20
}

$mesaj = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guess = (int)($_POST['guess'] ?? 0);

    if ($guess < $_SESSION['numar']) {
        $mesaj = "🔼 Numărul este MAI MARE!";
    } elseif ($guess > $_SESSION['numar']) {
        $mesaj = "🔽 Numărul este MAI MIC!";
    } else {
        $mesaj = "🎉 AI GHICIT! Jocul se resetează!";
        unset($_SESSION['numar']); // resetează jocul
    }
}
?>
<!DOCTYPE html>
<html>
<body style="font-family:Arial; padding:20px;">
<h1>🎮 Joc: Ghicește numărul (1–20)</h1>

<p><?php echo $mesaj; ?></p>

<form method="POST">
    <input type="number" name="guess" placeholder="Număr între 1 și 20">
    <button type="submit">Ghicește!</button>
</form>

</body>
</html>
