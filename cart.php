<?php include 'header.php'; ?>

<?php
$total = getCartTotal();
$count = getCartCount();
?>

<main style="flex:1; display:flex; flex-direction:column; padding:0 15px 20px; gap:20px;">
    <?php if(empty($_SESSION['cart'])): ?>
    <div style="flex:1; display:flex; align-items:center; justify-content:center;">
        <div class="card post-card" style="flex:none; width:400px; height:250px; flex-direction:column; gap:20px;">
            <h2>Your cart is empty</h2>
            <a href="catalogue.php" class="buy-button" style="font-size:1.8rem; display:inline-block;">Browse Catalogue</a>
        </div>
    </div>
    <?php else: ?>

    <div class="catalogue-grid" style="overflow:visible;">
        <?php foreach($_SESSION['cart'] as $key => $item):
            $p = $products[$item['product_id']];
        ?>
        <div class="product-item">
            <a href="product_detail.php?id=<?= $p['id'] ?>" class="catalogue-post" style="text-decoration:none; color:inherit; cursor:pointer;">
                <div style="text-align:center; padding:10px;">
                    <h2 style="font-size:2rem;"><?= $p['name'] ?></h2>
                    <p style="font-size:1.5rem;">Size: <?= $item['size'] ?></p>
                    <p style="font-size:1.5rem;">Qty: <?= $item['qty'] ?></p>
                    <p style="font-size:2rem; font-weight:bold;">$<?= $p['price'] * $item['qty'] ?></p>
                </div>
            </a>
            <div class="cart-action-row">
                <form method="POST" action="cart_actions.php">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="key" value="<?= htmlspecialchars($key) ?>">
                    <button type="submit" class="remove-button">🗑 Remove</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div style="display:flex; justify-content:flex-end; align-items:center; gap:30px; padding-right:10px;">
        <span style="font-size:3rem;">Total: <strong>$<?= $total ?></strong></span>
        <a href="payment.php" class="buy-button" style="font-size:2rem; display:inline-block; background:#9BD576; padding:10px 30px;">
            Checkout →
        </a>
    </div>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
