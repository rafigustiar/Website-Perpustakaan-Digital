<?php
require_once 'db.php';

$pdo    = getPDO();
$errors = [];
$title = $author = $publisher = $year = $category = $isbn = $pages = $stock = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title     = trim($_POST['title'] ?? '');
    $author    = trim($_POST['author'] ?? '');
    $publisher = trim($_POST['publisher'] ?? '');
    $year      = trim($_POST['year'] ?? '');
    $category  = trim($_POST['category'] ?? '');
    $isbn      = trim($_POST['isbn'] ?? '');
    $pages     = trim($_POST['pages'] ?? '');
    $stock     = trim($_POST['stock'] ?? '0');

    // Validasi sederhana
    if ($title === '') {
        $errors[] = 'Judul wajib diisi.';
    }
    if ($author === '') {
        $errors[] = 'Penulis wajib diisi.';
    }
    if ($year !== '' && !ctype_digit($year)) {
        $errors[] = 'Tahun harus berupa angka.';
    }
    if ($pages !== '' && !ctype_digit($pages)) {
        $errors[] = 'Jumlah halaman harus berupa angka.';
    }
    if ($stock !== '' && !ctype_digit($stock)) {
        $errors[] = 'Stok harus berupa angka.';
    }

    // Upload cover (opsional)
    $coverName = null;
    if (!empty($_FILES['cover']['name'])) {
        $uploadDir  = __DIR__ . '/assets/img/cover/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmp  = $_FILES['cover']['tmp_name'];
        $fileName = basename($_FILES['cover']['name']);
        $fileSize = $_FILES['cover']['size'];
        $fileType = mime_content_type($fileTmp);
        $ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExt  = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedMime = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($ext, $allowedExt, true) || !in_array($fileType, $allowedMime, true)) {
            $errors[] = 'File cover harus berupa gambar (JPG/PNG/GIF).';
        } elseif ($fileSize > 2 * 1024 * 1024) {
            $errors[] = 'Ukuran file cover maksimal 2MB.';
        } else {
            $coverName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $fileName);
            if (!move_uploaded_file($fileTmp, $uploadDir . $coverName)) {
                $errors[] = 'Gagal mengupload file cover.';
            }
        }
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO books (title, author, publisher, year, category, isbn, pages, stock, cover)
            VALUES (:title, :author, :publisher, :year, :category, :isbn, :pages, :stock, :cover)
        ");

        $stmt->execute([
            ':title'     => $title,
            ':author'    => $author,
            ':publisher' => $publisher ?: null,
            ':year'      => $year !== '' ? (int)$year : null,
            ':category'  => $category ?: null,
            ':isbn'      => $isbn ?: null,
            ':pages'     => $pages !== '' ? (int)$pages : null,
            ':stock'     => $stock !== '' ? (int)$stock : 0,
            ':cover'     => $coverName,
        ]);

        header('Location: index.php?msg=' . urlencode('Buku berhasil ditambahkan.'));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku - Perpustakaan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
    <div class="container flex-between">
        <h1 class="logo">Perpustakaan Digital</h1>
        <nav class="nav-links">
            <a href="index.php">Daftar Buku</a>
            <a href="create.php" class="active">Tambah Buku</a>
        </nav>
    </div>
</header>

<main class="container">
    <section class="card">
        <div class="card-header">
            <h2>Tambah Buku Baru</h2>
            <p class="text-muted">Isi form di bawah untuk menambahkan buku ke koleksi perpustakaan.</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert danger">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo e($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="form-grid">
            <div class="form-group">
                <label for="title">Judul <span class="required">*</span></label>
                <input type="text" id="title" name="title"
                       value="<?php echo e($title); ?>" required>
            </div>

            <div class="form-group">
                <label for="author">Penulis <span class="required">*</span></label>
                <input type="text" id="author" name="author"
                       value="<?php echo e($author); ?>" required>
            </div>

            <div class="form-group">
                <label for="publisher">Penerbit</label>
                <input type="text" id="publisher" name="publisher"
                       value="<?php echo e($publisher); ?>">
            </div>

            <div class="form-group">
                <label for="year">Tahun Terbit</label>
                <input type="number" id="year" name="year" min="0" max="<?php echo date('Y') + 1; ?>"
                       value="<?php echo e($year); ?>">
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <input type="text" id="category" name="category"
                       placeholder="Misal: Pemrograman, Jaringan, Novel"
                       value="<?php echo e($category); ?>">
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn"
                       value="<?php echo e($isbn); ?>">
            </div>

            <div class="form-group">
                <label for="pages">Jumlah Halaman</label>
                <input type="number" id="pages" name="pages" min="0"
                       value="<?php echo e($pages); ?>">
            </div>

            <div class="form-group">
                <label for="stock">Stok</label>
                <input type="number" id="stock" name="stock" min="0"
                       value="<?php echo e($stock); ?>">
            </div>

            <div class="form-group">
                <label for="cover">Cover Buku (opsional)</label>
                <input type="file" id="cover" name="cover" accept="image/*">
                <small class="text-muted">Format: JPG/PNG/GIF, maks 2MB.</small>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn ghost">Kembali</a>
                <button type="submit" class="btn primary">Simpan</button>
            </div>
        </form>
    </section>
</main>

<footer class="footer">
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> Perpustakaan Digital</p>
    </div>
</footer>
</body>
</html>
