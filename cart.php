<?php include 'header.php'; ?>

<main class="carousel-wrapper">
    <button class="carousel-btn left">&lt;</button>
    
    <div class="catalogue-grid">
        <?php for($i=1; $i<=10; $i++): ?>
        <div class="product-item">
            <div class="catalogue-post">
                <h2>Post 1</h2>
            </div>
            <div class="cart-action-row">
                <span class="cart-price">XXX</span>
                <button class="remove-button">Remove Button 1</button>
            </div>
        </div>
        <?php endfor; ?>
    </div>

    <button class="carousel-btn right">&gt;</button>
</main>

<?php include 'footer.php'; ?>
