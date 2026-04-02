<?php 
include 'header.php';
$success = isset($_GET['success']);
if ($success && !empty($_SESSION['cart'])) {
    // already cleared by cart_actions
}
$total = getCartTotal();
$cartItems = $_SESSION['cart'];
?>

<main style="display:flex; flex-direction:column; align-items:center; width:100%; max-width:800px; margin:0 auto; padding:0 20px 40px; gap:30px; flex:1;">
<?php if($success): ?>
    <div class="card" style="background:#9BD576; border-radius:20px; padding:40px; text-align:center; width:100%; min-height:400px; flex-direction:column;">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="80" height="80" style="margin-bottom:20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h2 style="font-size:4.5rem;">Order Confirmed!</h2>
        <p style="font-size:2.5rem; margin-top:15px;">Thank you for your purchase.<br>You'll receive an email shortly.</p>
        <a href="catalogue.php" class="buy-button" style="display:inline-flex; width:auto; margin-top:40px; font-size:2.2rem; padding:15px 40px;">Continue Shopping</a>
    </div>
<?php elseif(empty($cartItems)): ?>
    <div class="card" style="background:#f7f3e8; border-radius:20px; padding:40px; text-align:center; width:100%; min-height:400px; flex-direction:column;">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="80" height="80" style="margin-bottom:20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.35 5.4A2 2 0 007.6 21h8.8a2 2 0 001.95-1.6L19 13.5M9 21h.01M15 21h.01"></path></svg>
        <h2 style="font-size:3.5rem;">Your cart is empty!</h2>
        <a href="catalogue.php" class="buy-button" style="display:inline-flex; width:auto; margin-top:30px; font-size:2.2rem; padding:15px 40px;">Browse Catalogue</a>
    </div>
<?php else: ?>
    <!-- Receipt Card -->
    <div style="width:100%; border:2px solid #1a1a1a; border-radius:20px; box-shadow:6px 6px 0px #1a1a1a; overflow:hidden; background-color:#f7f3e8;">
        <!-- Card Header -->
        <div style="background-color:#FFBB7F; padding:25px; border-bottom:2px solid #1a1a1a; text-align:center;">
            <h2 style="font-size:3.5rem;">Order Summary</h2>
            <p style="font-size:1.8rem; margin-top:5px;"><?= count($cartItems) ?> item(s) in your cart</p>
        </div>
        
        <!-- Items List -->
        <div style="padding:10px 30px;">
            <?php foreach($cartItems as $item):
                $p = $products[$item['product_id']];
            ?>
            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px dashed #1a1a1a; padding:20px 0;">
                <div style="display:flex; flex-direction:column; gap:5px;">
                    <h3 style="font-size:2.4rem;"><?= $p['name'] ?></h3>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <span style="font-size:1.8rem;">Size: <?= htmlspecialchars($item['size'] ?? '') ?></span>
                        <?php if(!empty($item['color'])): ?>
                            <div style="width:15px; height:15px; border-radius:50%; border:1px solid #000; background-color:<?= htmlspecialchars($item['color']) ?>;"></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div style="text-align:right;">
                    <p style="font-size:2.6rem; font-weight:bold;">$<?= $p['price'] * $item['qty'] ?></p>
                    <p style="font-size:1.8rem;">Qty: <?= $item['qty'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Order Totals Box -->
        <div style="padding:30px; background-color:#FFBB7F; border-top:2px solid #1a1a1a;">
            <?php if($total >= 100): ?>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                <span style="font-size:2rem; display:flex; align-items:center; gap:8px;"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Free Delivery</span>
                <span style="font-size:2rem; font-weight:bold; color:#3d7a1a;">$0.00</span>
            </div>
            <?php else: ?>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                <span style="font-size:2rem;">Standard Delivery</span>
                <span style="font-size:2rem; font-weight:bold;">$5.00</span>
            </div>
            <p style="font-size:1.5rem; text-align:center; margin-bottom:15px;">(Add $<?= number_format(100 - $total, 2) ?> more for free delivery!)</p>
            <?php endif; ?>
            
            <div style="display:flex; justify-content:space-between; align-items:center; padding-top:15px; border-top:2px solid #1a1a1a;">
                <span style="font-size:3.5rem; font-weight:bold;">Total:</span>
                <span style="font-size:3.5rem; font-weight:bold;">$<?= number_format($total < 100 ? $total + 5 : $total, 2) ?></span>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div style="width:100%; display:flex; flex-direction:column; gap:20px; align-items:center;">
        <form method="POST" action="cart_actions.php" style="width:100%;">
            <input type="hidden" name="action" value="clear">
            <button type="submit" class="pay-safe-btn" style="width:100%; display:flex; justify-content:center; gap:15px; align-items:center; padding:20px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="32" height="32"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Pay Securely
            </button>
        </form>
        <a href="cart.php" class="page-link" style="width:auto; padding:10px 30px; display:inline-flex; gap:10px; border-radius:20px;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Edit Cart
        </a>
    </div>
<?php endif; ?>
</main>

<?php include 'footer.php'; ?>
