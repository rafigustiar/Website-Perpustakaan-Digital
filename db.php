<?php
// db.php
// Konfigurasi koneksi database MySQL (Laragon)
const DB_HOST = '127.0.0.1';
const DB_PORT = '3306';
const DB_NAME = 'perpustakaan_db';
const DB_USER = 'root';
const DB_PASS = '';  // default Laragon kosong
/**
 * Mengembalikan instance PDO (singleton).
 */
function getPDO(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die('Koneksi database gagal: ' . $e->getMessage());
        }
    }

    return $pdo;
}

/**
 * Helper untuk escape output HTML.
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Helper untuk base URL sederhana (opsional).
 * Misal projek diletakkan di http://perpustakaan.test (Laragon virtual host)
 */
function base_url(string $path = ''): string
{
    return $path;
}
