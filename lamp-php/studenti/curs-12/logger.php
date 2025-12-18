<?php
// logger.php - demo scriere log (append)
date_default_timezone_set('Europe/Bucharest');

$logDir = __DIR__ . '/storage';
$logFile = $logDir . '/app.log';

if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}

$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$time = date('Y-m-d H:i:s');

$line = "[$time] IP=$ip UA=" . str_replace(["\n","\r"], '', $ua) . PHP_EOL;

// FILE_APPEND = adaugă la final
// LOCK_EX = blochează fișierul în timpul scrierii
file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);

echo "Am scris în log! Verifică storage/app.log";
