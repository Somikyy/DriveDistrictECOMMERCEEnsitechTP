<?php 
include 'header.php';
$id = (int)($_GET['id'] ?? 1);
$p = $products[$id] ?? $products[1];
?>

<main class="product-detail-grid">
    <div class="product-left">
        <div class="product-image" style="position:relative;">
            <div style="text-align:center; padding:20px;">
                <h2 style="font-size:2.5rem;"><?= htmlspecialchars($p['name']) ?></h2>
                <p style="font-size:1.8rem; margin-top:10px;"><?= $p['category'] ?></p>
            </div>
        </div>
        <div class="product-colors" style="max-width:100%; justify-content:center; gap:15px;">
            <?php foreach($p['colors'] as $color): ?>
            <div class="color-box" style="background-color:<?= $color ?>; width:40px; height:40px; border:2px solid #000; cursor:pointer;" onclick="this.parentElement.querySelectorAll('.color-box').forEach(b=>b.style.outline='');this.style.outline='3px solid #000';"></div>
            <?php endforeach; ?>
        </div>
        <div class="product-metadata" style="margin-top:5px;">
            <p><?= $p['stock'] ?> in stock</p>
            <p style="font-size:2.5rem; font-weight:bold;">$<?= $p['price'] ?></p>
        </div>
    </div>

    <div class="product-right">
        <div class="product-description" style="padding:30px;">
            <div style="text-align:center;">
                <h2 style="font-size:2.5rem; margin-bottom:20px;"><?= htmlspecialchars($p['name']) ?></h2>
                <p style="font-size:1.8rem; line-height:1.5; font-family: sans-serif; font-weight:normal;"><?= $p['desc'] ?></p>
            </div>
        </div>
        <div class="product-action" style="flex-direction:column; align-items: flex-end; gap:15px;">
            <form method="POST" action="cart_actions.php" style="display:flex; flex-direction:column; align-items:flex-end; gap:10px;">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                <input type="hidden" name="redirect" value="product_detail.php?id=<?= $p['id'] ?>">
                <div style="display:flex; gap:10px; flex-wrap:wrap; justify-content:flex-end;">
                    <?php foreach($p['sizes'] as $i => $size): ?>
                    <label style="cursor:pointer;">
                        <input type="radio" name="size" value="<?= $size ?>" <?= $i===0 ? 'checked' : '' ?> style="display:none;" class="size-radio">
                        <span class="size-btn"><?= $size ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
                <button type="submit" class="buy-button" style="font-size:2rem; padding:10px 30px;">Add to Cart</button>
            </form>
            <a href="catalogue.php" class="buy-button" style="font-size:1.5rem;">← Back to Catalogue</a>
        </div>
    </div>
</main>

<style>
.size-btn { display:inline-block; padding:6px 14px; border:2px solid #1a1a1a; border-radius:8px; font-family:'Jersey 25',sans-serif; font-size:1.5rem; background:#FFBB7F; cursor:pointer; }
input.size-radio:checked + .size-btn { background:#1a1a1a; color:#FFBB7F; }
</style>

<?php include 'footer.php'; ?>
