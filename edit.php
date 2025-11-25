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

$errors = [];
$title     = $book['title'];
$author    = $book['author'];
$publisher = $book['publisher'];
$year      = $book['year'];
$category  = $book['category'];
$isbn      = $book['isbn'];
$pages     = $book['pages'];
$stock     = $book['stock'];
$coverOld  = $book['cover'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title     = trim($_POST['title'] ?? '');
    $author    = trim($_POST['author'] ?? '');
    $publisher = trim($_POST['publisher'] ?? '');
    $year      = trim($_POST['year'] ?? '');
    $category  = trim($_POST['category'] ?? '');
    $isbn      = trim($_POST['isbn'] ?? '');
    $pages     = trim($_POST['pages'] ?? '');
    $stock     = trim($_POST['stock'] ?? '0');

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

    // Upload cover baru (opsional)
    $coverName = $coverOld;
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
            } else {
                // Hapus cover lama jika ada
                if ($coverOld && file_exists($uploadDir . $coverOld)) {
                    @unlink($uploadDir . $coverOld);
                }
            }
        }
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            UPDATE books
            SET title = :title,
                author = :author,
                publisher = :publisher,
                year = :year,
                category = :category,
                isbn = :isbn,
                pages = :pages,
                stock = :stock,
                cover = :cover
            WHERE id = :id
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
            ':id'        => (int)$id,
        ]);

        header('Location: index.php?msg=' . urlencode('Data buku berhasil diperbarui.'));
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku - Perpustakaan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
    <div class="container flex-between">
        <h1 class="logo">Perpustakaan Digital</h1>
        <nav class="nav-links">
            <a href="index.php" class="active">Daftar Buku</a>
            <a href="create.php">Tambah Buku</a>
        </nav>
    </div>
</header>

<main class="container">
    <section class="card">
        <div class="card-header">
            <h2>Edit Data Buku</h2>
            <p class="text-muted">Perbarui informasi buku di perpustakaan.</p>
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
                       value="<?php echo e((string)$publisher); ?>">
            </div>

            <div class="form-group">
                <label for="year">Tahun Terbit <span class="required">*</span></label>
                <input type="number" id="year" name="year" min="0" max="<?php echo date('Y') + 1; ?>"
                       value="<?php echo e((string)$year); ?>">
            </div>

            <div class="form-group">
                <label for="category">Kategori <span class="required">*</span></label>
                <input type="text" id="category" name="category"
                       value="<?php echo e((string)$category); ?>">
            </div>

            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" id="isbn" name="isbn"
                       value="<?php echo e((string)$isbn); ?>">
            </div>

            <div class="form-group">
                <label for="pages">Jumlah Halaman <span class="required">*</span></label>
                <input type="number" id="pages" name="pages" min="0"
                       value="<?php echo e((string)$pages); ?>">
            </div>

            <div class="form-group">
                <label for="stock">Stok</label>
                <input type="number" id="stock" name="stock" min="0"
                       value="<?php echo e((string)$stock); ?>">
            </div>

            <div class="form-group">
                <label>Cover Saat Ini</label>
                <?php if ($coverOld): ?>
                    <img src="assets/img/cover/<?php echo e($coverOld); ?>" alt="Cover" class="thumbnail">
                <?php else: ?>
                    <p class="text-muted">Belum ada cover.</p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="cover">Ganti Cover (opsional)</label>
                <input type="file" id="cover" name="cover" accept="image/*">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti cover.</small>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn ghost">Kembali</a>
                <button type="submit" class="btn primary">Update</button>
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
