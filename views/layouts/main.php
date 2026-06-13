<?php
// views/layouts/main.php
?>
<!DOCTYPE html>
<html lang="vi" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'CinemaX - Đặt vé xem phim trực tuyến') ?></title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Bootstrap 5.3 Light Mode -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/app.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/oauth.css?v=<?= time() ?>">
</head>

<body class="bg-light text-dark min-vh-100 d-flex flex-column">

    <!-- Navbar -->
    <?php require VIEW_PATH . '/partials/navbar.php'; ?>

    <!-- Flash Messages -->
    <?php require VIEW_PATH . '/partials/flash_message.php'; ?>

    <!-- Main Content -->
    <main class="container py-4 flex-grow-1">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <?php require VIEW_PATH . '/partials/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="/assets/js/seat_selector.js?v=<?= time() ?>"></script>
    <script src="/assets/js/oauth.js?v=<?= time() ?>"></script>
    <script src="/assets/js/app.js?v=<?= time() ?>"></script>
</body>
</html>
