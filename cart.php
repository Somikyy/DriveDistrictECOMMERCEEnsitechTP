<?php include 'header.php'; ?>
<?php 
$cart_items = ["Vintage Zip-Up", "Oversized Tee", "Cargo Pants"];
?>
<main class="carousel-wrapper">
    <button class="carousel-btn left">&lt;</button>
    
    <div class="catalogue-grid">
        <?php foreach($cart_items as $name): ?>
        <div class="product-item">
            <div class="catalogue-post">
                <h2 style="text-align:center;"><?= $name ?></h2>
            </div>
            <div class="cart-action-row">
                <span class="cart-price">$<?= rand(39, 99) ?></span>
                <button class="remove-button">Remove</button>
            </div>
        </div>
        <?php endforeach; ?>
        <?php for($i=count($cart_items); $i<10; $i++): ?>
        <div class="product-item">
            <div class="catalogue-post" style="opacity: 0.3;">
                <h2>Empty</h2>
            </div>
        </div>
        <?php endfor; ?>
    </div>

    <button class="carousel-btn right">&gt;</button>
</main>

<?php include 'footer.php'; ?>
