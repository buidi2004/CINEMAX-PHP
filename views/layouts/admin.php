<?php
// views/layouts/admin.php
?>
<!DOCTYPE html>
<html lang="vi" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'CinemaX Admin Dashboard') ?></title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Bootstrap 5.3 Dark Mode -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/app.css">
</head>

<body class="bg-dark text-light min-vh-100 d-flex flex-column">

    <!-- Navbar -->
    <?php require VIEW_PATH . '/partials/navbar.php'; ?>

    <div class="container-fluid flex-grow-1 d-flex">
        <div class="row w-100 flex-grow-1">
            <!-- Sidebar -->
            <?php require VIEW_PATH . '/partials/admin_sidebar.php'; ?>

            <!-- Main Panel Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 bg-dark">
                <!-- Flash Messages -->
                <?php require VIEW_PATH . '/partials/flash_message.php'; ?>
                
                <?= $content ?>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-black text-secondary text-center py-3 border-top border-secondary">
        <small>&copy; <?= date('Y') ?> CinemaX. Admin Panel.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
