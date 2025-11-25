<?php
require_once 'db.php';

$pdo = getPDO();

// Pencarian
$q = $_GET['q'] ?? '';
if ($q !== '') {
    $like = '%' . $q . '%';

    $stmt = $pdo->prepare("
        SELECT * FROM books
        WHERE title   LIKE :title
           OR author  LIKE :author
           OR category LIKE :category
        ORDER BY id DESC
    ");

    $stmt->execute([
        ':title'    => $like,
        ':author'   => $like,
        ':category' => $like,
    ]);
} else {
    $stmt = $pdo->query("SELECT * FROM books ORDER BY id DESC");
}
$books = $stmt->fetchAll();

// Pesan flash
$msg   = $_GET['msg']   ?? '';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan - Daftar Buku</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="topbar">
    <div class="container flex-between">
        <h1 class="logo">Perpustakaan UMM Digital</h1>
        <nav class="nav-links">
            <a href="index.php" class="active">Daftar Buku</a>
            <a href="create.php">Tambah Buku</a>
        </nav>
    </div>
</header>

<main class="container">

    <?php if ($msg): ?>
        <div class="alert success"><?php echo e($msg); ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert danger"><?php echo e($error); ?></div>
    <?php endif; ?>

    <section class="card">
        <div class="card-header flex-between">
            <div>
                <h2>Daftar Koleksi Buku</h2>
                <p class="text-muted">Kelola data buku perpustakaan Anda dengan mudah.</p>
            </div>
            <a href="create.php" class="btn primary">+ Tambah Buku</a>
        </div>

        <form method="get" class="search-bar">
            <input type="text" name="q" placeholder="Cari judul, penulis, atau kategori..."
                   value="<?php echo e($q); ?>">
            <button type="submit" class="btn">Cari</button>
            <?php if ($q !== ''): ?>
                <a href="index.php" class="btn ghost">Reset</a>
            <?php endif; ?>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Kategori</th>
                    <th>Tahun</th>
                    <th>ISBN</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($books) === 0): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            Belum ada data buku atau hasil pencarian tidak ditemukan.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; ?>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <?php if (!empty($book['cover'])): ?>
                                    <img src="assets/img/cover/<?php echo e($book['cover']); ?>"
                                         alt="Cover" class="thumbnail">
                                <?php else: ?>
                                    <span class="badge badge-muted">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo e($book['title']); ?></strong><br>
                                <small class="text-muted">
                                    <?php echo e($book['publisher'] ?: '-'); ?>
                                </small>
                            </td>
                            <td><?php echo e($book['author']); ?></td>
                            <td><?php echo e($book['category'] ?: '-'); ?></td>
                            <td><?php echo e($book['year'] ?: '-'); ?></td>
                            <td><?php echo e($book['isbn'] ?: '-'); ?></td>
                            <td><?php echo e((string)($book['stock'] ?? 0)); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo e((string)$book['id']); ?>" class="btn small">Edit</a>
                                <a href="delete.php?id=<?php echo e((string)$book['id']); ?>"
                                   class="btn small danger"
                                   onclick="return confirm('Yakin ingin menghapus buku ini?');">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> Perpustakaan UMM Digital · Dibuat dengan penuh semangat oleh kelompok Anak Ajaib</p>
    </div>
</footer>
</body>
</html>
