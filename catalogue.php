<?php include 'header.php'; ?>

<main class="carousel-wrapper">
    <button class="carousel-btn left">&lt;</button>
    
    <div class="catalogue-grid">
        <?php for($i=1; $i<=10; $i++): ?>
        <div class="product-item">
            <div class="catalogue-post">
                <h2>Post <?php echo $i; ?></h2>
            </div>
            <button class="buy-button">Buy Button <?php echo $i; ?></button>
        </div>
        <?php endfor; ?>
    </div>

    <button class="carousel-btn right">&gt;</button>
</main>

<?php include 'footer.php'; ?>
