<?php require_once 'data.php'; 
$cartCount = getCartCount();
$currentPage = basename($_SERVER['PHP_SELF']);
function navClass($page) { global $currentPage; return $currentPage === $page ? 'nav-link active' : 'nav-link'; }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive District</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jersey+25&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css?v=<?= time() ?>">
</head>
<body>
    <header class="header">
        <h1><a href="index.php" style="color:inherit;text-decoration:none;">Drive District</a></h1>
    </header>

    <nav class="nav-bar">
        <a href="index.php" class="<?= navClass('index.php') ?>">Home</a>
        <a href="catalogue.php" class="<?= navClass('catalogue.php') ?>">Catalogue</a>
        <a href="social_media.php" class="<?= navClass('social_media.php') ?>">Social Media</a>
        <a href="informations.php" class="<?= navClass('informations.php') ?>">Informations</a>
        <a href="histoire.php" class="<?= navClass('histoire.php') ?>">Histoire</a>
        <a href="faq.php" class="<?= navClass('faq.php') ?>">FAQ</a>
        <a href="a_propos.php" class="<?= navClass('a_propos.php') ?>">À propos</a>
        <?php if(isAdmin()): ?>
            <a href="admin.php" class="<?= navClass('admin.php') ?>" style="background-color:#9BD576;">Admin</a>
        <?php endif; ?>
        <a href="cart.php" class="<?= navClass('cart.php') ?> cart-link" style="display:flex; align-items:center; gap:5px;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.35 5.4A2 2 0 007.6 21h8.8a2 2 0 001.95-1.6L19 13.5M9 21h.01M15 21h.01"></path></svg> Cart <?php if($cartCount > 0): ?><span class="cart-badge"><?= $cartCount ?></span><?php endif; ?>
        </a>
        <?php if(isLoggedIn()): ?>
            <a href="login.php?logout=1" class="nav-link" style="background-color:#ff6b6b; color:#fff;">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
        <?php else: ?>
            <a href="login.php" class="<?= navClass('login.php') ?>">Login</a>
        <?php endif; ?>
    </nav>
