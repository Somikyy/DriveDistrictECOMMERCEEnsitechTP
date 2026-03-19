<?php include 'header.php'; ?>

<main class="carousel-wrapper">
    <button class="carousel-btn left" onclick="scrollCatalogue(-1)">&lt;</button>

    <div class="catalogue-grid" id="catalogueGrid">
        <?php foreach($products as $p): ?>
        <div class="product-item">
            <a href="product_detail.php?id=<?= $p['id'] ?>" class="catalogue-post" style="text-decoration:none; color:inherit; cursor:pointer;">
                <div style="text-align:center;">
                    <h2><?= $p['name'] ?></h2>
                    <p style="font-size:1.5rem;"><?= $p['category'] ?></p>
                    <p style="font-size:2rem; margin-top:5px;">$<?= $p['price'] ?></p>
                </div>
            </a>
            <form method="POST" action="cart_actions.php" style="width:100%;">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                <input type="hidden" name="size" value="<?= $p['sizes'][2] ?? $p['sizes'][0] ?>">
                <input type="hidden" name="redirect" value="catalogue.php">
                <button type="submit" class="buy-button">Add to Cart — $<?= $p['price'] ?></button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>

    <button class="carousel-btn right" onclick="scrollCatalogue(1)">&gt;</button>
</main>

<script>
function scrollCatalogue(dir) {
    const grid = document.getElementById('catalogueGrid');
    grid.scrollBy({ left: dir * 300, behavior: 'smooth' });
}
</script>

<?php include 'footer.php'; ?>
