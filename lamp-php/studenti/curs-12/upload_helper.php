<?php
// upload_helper.php

function upload_poza_student(string $inputName = 'poza', string $uploadDir = __DIR__ . '/uploads'): array
{
    // return: ['ok' => bool, 'filename' => ?string, 'error' => ?string]

    if (!isset($_FILES[$inputName]) || $_FILES[$inputName]['error'] === UPLOAD_ERR_NO_FILE) {
        return ['ok' => true, 'filename' => null, 'error' => null]; // nu s-a urcat nimic (opțional)
    }

    $file = $_FILES[$inputName];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'filename' => null, 'error' => 'Eroare la upload (cod: ' . $file['error'] . ').'];
    }

    // limită dimensiune (ex: 2MB)
    $maxBytes = 2 * 1024 * 1024;
    if ($file['size'] > $maxBytes) {
        return ['ok' => false, 'filename' => null, 'error' => 'Fișier prea mare (max 2MB).'];
    }

    // verificare MIME real (nu doar extensia)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($allowed[$mime])) {
        return ['ok' => false, 'filename' => null, 'error' => 'Tip fișier invalid. Permis: JPG/PNG/WEBP.'];
    }

    // asigură-te că există directorul
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            return ['ok' => false, 'filename' => null, 'error' => 'Nu pot crea directorul uploads/.'];
        }
    }

    // nume de fișier sigur (fără numele original)
    $ext = $allowed[$mime];
    $rand = bin2hex(random_bytes(8));
    $filename = "st_" . time() . "_" . $rand . "." . $ext;

    $dest = rtrim($uploadDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return ['ok' => false, 'filename' => null, 'error' => 'Nu am putut salva fișierul pe server.'];
    }

    return ['ok' => true, 'filename' => $filename, 'error' => null];
}
