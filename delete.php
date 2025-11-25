<?php
require_once 'db.php';

$pdo = getPDO();

$id = $_GET['id'] ?? null;
if (!$id || !ctype_digit($id)) {
    header('Location: index.php?error=' . urlencode('Parameter ID tidak valid.'));
    exit;
}

// Ambil data buku
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id");
$stmt->execute([':id' => (int)$id]);
$book = $stmt->fetch();

if (!$book) {
    header('Location: index.php?error=' . urlencode('Data buku tidak ditemukan.'));
    exit;
}

// Proses hapus (via GET + konfirmasi JS di index, atau bisa pakai POST di sini)
$uploadDir = __DIR__ . '/assets/img/cover/';
if ($book['cover'] && file_exists($uploadDir . $book['cover'])) {
    @unlink($uploadDir . $book['cover']);
}

$stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
$stmt->execute([':id' => (int)$id]);

header('Location: index.php?msg=' . urlencode('Buku berhasil dihapus.'));
exit;
