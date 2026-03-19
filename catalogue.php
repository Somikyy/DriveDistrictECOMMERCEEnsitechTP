<?php include 'header.php'; ?>
<?php 
$products = [
    "Vintage Zip-Up", "Oversized Tee", "Cargo Pants", "Street Beanie", "Puffer Jacket",
    "Heavyweight Hoodie", "Denim Jeans", "Graphic Longsleeve", "Varsity Jacket", "Sneakers"
];
?>
<main class="carousel-wrapper">
    <button class="carousel-btn left">&lt;</button>
    <div class="catalogue-grid">
        <?php foreach($products as $index => $name): ?>
        <div class="product-item">
            <div class="catalogue-post">
                <h2><?= $name ?></h2>
            </div>
            <button class="buy-button">Buy $<?= rand(29, 129) ?></button>
        </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-btn right">&gt;</button>
</main>
<?php include 'footer.php'; ?>
