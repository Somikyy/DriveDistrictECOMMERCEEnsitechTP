<?php include 'header.php'; ?>

<?php
$total = getCartTotal();
$count = getCartCount();

$page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
$limit = 8;
$cart_items = $_SESSION['cart'] ?? [];
$total_items = count($cart_items);
$total_pages = ceil($total_items / $limit);
if ($page > $total_pages && $total_pages > 0) $page = $total_pages;

$offset = ($page - 1) * $limit;
$current_cart = array_slice($cart_items, $offset, $limit, true);
?>

<main style="flex:1; display:flex; flex-direction:column; padding:0 15px 20px; gap:20px; align-items:center;">
    <?php if(empty($cart_items)): ?>
    <div style="flex:1; display:flex; align-items:center; justify-content:center; width:100%;">
        <div class="card post-card" style="flex:none; width:400px; height:250px; flex-direction:column; gap:20px;">
            <h2>Your cart is empty</h2>
            <a href="catalogue.php" class="buy-button" style="font-size:1.8rem; display:flex; align-items:center; justify-content:center; gap:8px; text-decoration:none; margin:0 auto; width:80%;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Browse Catalogue
            </a>
        </div>
    </div>
    <?php else: ?>

    <div class="catalogue-grid">
        <?php foreach($current_cart as $key => $item):
            $p = $products[$item['product_id']];
        ?>
        <div class="product-item">
            <a href="product_detail.php?id=<?= $p['id'] ?>" class="catalogue-post" style="text-decoration:none; color:inherit; cursor:pointer;">
                <div style="text-align:center; padding:10px;">
                    <h2 style="font-size:2rem;"><?= $p['name'] ?></h2>
                    <div style="display:flex; justify-content:center; align-items:center; gap:10px; margin-top:5px;">
                        <p style="font-size:1.5rem;">Size: <?= htmlspecialchars($item['size'] ?? '') ?></p>
                        <?php if(!empty($item['color'])): ?>
                        <div style="width:20px; height:20px; border-radius:50%; border:1px solid #000; background-color:<?= htmlspecialchars($item['color']) ?>;"></div>
                        <?php endif; ?>
                    </div>
                    <p style="font-size:2rem; font-weight:bold; margin-top:10px;">$<?= $p['price'] * $item['qty'] ?></p>
                </div>
            </a>
            <div class="cart-action-row" style="display:flex; justify-content:center; align-items:center; gap:10px; padding:10px; flex-wrap:wrap; margin-top:-5px;">
                <form method="POST" action="cart_actions.php" style="margin:0;">
                    <input type="hidden" name="action" value="decrease">
                    <input type="hidden" name="key" value="<?= htmlspecialchars($key) ?>">
                    <button type="submit" class="qty-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </button>
                </form>
                <span style="font-size:2.2rem; font-weight:bold; width:30px; text-align:center;"><?= $item['qty'] ?></span>
                <form method="POST" action="cart_actions.php" style="margin:0;">
                    <input type="hidden" name="action" value="increase">
                    <input type="hidden" name="key" value="<?= htmlspecialchars($key) ?>">
                    <button type="submit" class="qty-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </form>
                
                <form method="POST" action="cart_actions.php" style="margin:0; margin-left:10px;">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="key" value="<?= htmlspecialchars($key) ?>">
                    <button type="submit" class="remove-button" style="display:flex; align-items:center; justify-content:center;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if($total_pages > 1): ?>
    <div class="pagination">
        <?php if($page > 1): ?>
            <a href="cart.php?p=<?= $page - 1 ?>" class="page-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
        <?php endif; ?>
        
        <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <a href="cart.php?p=<?= $i ?>" class="page-link <?= $i === $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if($page < $total_pages): ?>
            <a href="cart.php?p=<?= $page + 1 ?>" class="page-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div style="display:flex; justify-content:flex-end; align-items:center; gap:30px; padding-right:10px; width:100%; margin-top:20px;">
        <span style="font-size:3.5rem;">Total: <strong>$<?= number_format($total, 2) ?></strong></span>
        <a href="payment.php" class="pay-safe-btn" style="text-decoration:none; display:flex; align-items:center; justify-content:center; gap:10px; width:auto; font-size:2.5rem; padding:10px 40px;">
            Checkout 
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="28" height="28"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
    </div>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
