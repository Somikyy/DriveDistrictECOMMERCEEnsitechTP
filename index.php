<?php include 'header.php'; ?>

<main class="main-container">
    <div class="card post-card">
        <div style="text-align:center;">
            <h2 style="font-size:3.5rem; line-height:1.2;">New<br>Collection<br>2026</h2>
            <a href="catalogue.php" class="buy-button" style="display:inline-block;margin-top:20px;">Shop Now</a>
        </div>
    </div>
    <?php 
    $featured = [1 => $products[1], 6 => $products[6], 5 => $products[5]];
    foreach($featured as $p): ?>
    <div class="card text-button-card" style="flex-direction:column; gap:10px;">
        <a href="product_detail.php?id=<?= $p['id'] ?>" style="text-decoration:none; color:inherit; width:100%; text-align:center;">
            <h2><?= $p['name'] ?></h2>
            <p style="font-size:1.8rem;">$<?= $p['price'] ?></p>
        </a>
        <form method="POST" action="cart_actions.php">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
            <input type="hidden" name="size" value="<?= $p['sizes'][2] ?? $p['sizes'][0] ?>">
            <input type="hidden" name="redirect" value="index.php">
            <button type="submit" class="buy-button">Add to Cart</button>
        </form>
    </div>
    <?php endforeach; ?>
    <div class="card vertical-card">
        <h2>Summer<br>Sale<br>-20%</h2>
    </div>
</main>

<?php include 'footer.php'; ?>