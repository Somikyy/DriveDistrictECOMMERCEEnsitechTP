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
    <link rel="stylesheet" href="styles.css">
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
        <a href="cart.php" class="<?= navClass('cart.php') ?> cart-link">
            🛒 Cart <?php if($cartCount > 0): ?><span class="cart-badge"><?= $cartCount ?></span><?php endif; ?>
        </a>
    </nav>
