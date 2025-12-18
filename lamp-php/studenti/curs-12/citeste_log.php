<?php
$logFile = __DIR__ . '/storage/app.log';

if (!file_exists($logFile)) {
    die("Nu există log încă. Rulează logger.php întâi.");
}

$content = file_get_contents($logFile);

header('Content-Type: text/plain; charset=utf-8');
echo $content;
