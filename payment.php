<?php 
include 'header.php';
$success = isset($_GET['success']);
if ($success && !empty($_SESSION['cart'])) {
    // already cleared by cart_actions
}
$total = getCartTotal();
$cartItems = $_SESSION['cart'];
?>

<main class="payment-layout">
<?php if($success): ?>
    <div class="card" style="background:#9BD576; border-radius:20px; padding:40px; text-align:center; min-width:400px;">
        <h2 style="font-size:3.5rem;">✅ Order confirmed!</h2>
        <p style="font-size:2rem; margin-top:20px;">Thank you for your purchase.<br>You'll receive an email shortly.</p>
        <a href="catalogue.php" class="buy-button" style="display:inline-block; margin-top:30px; font-size:2rem;">Continue Shopping</a>
    </div>
<?php elseif(empty($cartItems)): ?>
    <div style="text-align:center;">
        <h2 style="font-size:3rem;">Your cart is empty!</h2>
        <a href="catalogue.php" class="buy-button" style="display:inline-block; margin-top:20px; font-size:2rem;">Go to Catalogue</a>
    </div>
<?php else: ?>
    <div class="payment-titles">
        <h2 style="font-size:2rem;">Order Summary — <?= count($cartItems) ?> item(s)</h2>
        <?php if($total >= 100): ?>
        <h2 style="font-size:2rem; color:#3d7a1a;">🎉 Free delivery included!</h2>
        <?php else: ?>
        <h2 style="font-size:1.8rem;">Add $<?= 100 - $total ?> more for free delivery!</h2>
        <?php endif; ?>
    </div>

    <div class="payment-products" style="grid-template-columns:repeat(<?= min(5, count($cartItems)) ?>, 1fr);">
        <?php foreach($cartItems as $item):
            $p = $products[$item['product_id']];
        ?>
        <div class="payment-post">
            <div style="text-align:center; padding:10px;">
                <h2 style="font-size:1.8rem;"><?= $p['name'] ?></h2>
                <p style="font-size:1.5rem;">Size: <?= $item['size'] ?></p>
                <p style="font-size:1.5rem;">x<?= $item['qty'] ?></p>
                <p style="font-size:2rem; font-weight:bold;">$<?= $p['price'] * $item['qty'] ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <p style="font-size:2.5rem;">Total: <strong>$<?= $total ?><?= $total < 100 ? ' + $5 delivery' : '' ?></strong></p>

    <form method="POST" action="cart_actions.php">
        <input type="hidden" name="action" value="clear">
        <button type="submit" class="pay-safe-btn">Pay Securely $<?= $total < 100 ? $total + 5 : $total ?></button>
    </form>
    <a href="cart.php" style="font-size:1.8rem; color:#1a1a1a;">← Edit Cart</a>
<?php endif; ?>
</main>

<?php include 'footer.php'; ?>
