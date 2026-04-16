<?php include 'header.php'; ?>

<?php
$page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
$limit = 8;
$total_products = count($products);
$total_pages = ceil($total_products / $limit);
if ($page > $total_pages && $total_pages > 0) $page = $total_pages;

$offset = ($page - 1) * $limit;
$current_products = array_slice($products, $offset, $limit);
?>

<main style="display:flex; flex-direction:column; align-items:center; width:100%; gap:20px; flex:1; padding-bottom: 20px;">
    <div class="catalogue-grid">
        <?php foreach($current_products as $p): ?>
        <div class="product-item">
            <a href="product_detail.php?id=<?= $p['id'] ?>" class="catalogue-post" style="text-decoration:none; color:inherit; cursor:pointer; <?php if(!empty($p['image'])) echo "background-image: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(0,0,0,0.1) 100%), url('".$p['image']."'); background-size: cover; background-position: center;"; ?>">
                <div style="text-align:center; background: rgba(247, 243, 232, 0.95); padding: 10px 20px; border-radius: 15px; border: 2px solid #1a1a1a; box-shadow: 4px 4px 0px #1a1a1a; backdrop-filter: blur(4px); margin: 15px;">
                    <h2 style="font-size:2.2rem;"><?= $p['name'] ?></h2>
                    <p style="font-size:1.4rem; color:#555;"><?= $p['category'] ?></p>
                    <p style="font-size:2rem; margin-top:5px; font-weight:bold;">$<?= $p['price'] ?></p>
                </div>
            </a>
            <form method="POST" action="cart_actions.php" style="width:100%;">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                <input type="hidden" name="size" value="<?= $p['sizes'][2] ?? ($p['sizes'][0] ?? '') ?>">
                <input type="hidden" name="color" value="<?= htmlspecialchars($p['colors'][0] ?? '') ?>">
                <input type="hidden" name="redirect" value="catalogue.php?p=<?= $page ?>">
                <button type="submit" class="buy-button" style="display:flex; align-items:center; justify-content:center; gap:5px; margin:0 auto;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.35 5.4A2 2 0 007.6 21h8.8a2 2 0 001.95-1.6L19 13.5M9 21h.01M15 21h.01"></path></svg>
                    $<?= $p['price'] ?>
                </button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if($total_pages > 1): ?>
    <div class="pagination" style="display:flex; gap:10px; margin-top:10px;">
        <?php if($page > 1): ?>
            <a href="catalogue.php?p=<?= $page - 1 ?>" class="page-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
        <?php endif; ?>
        
        <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <a href="catalogue.php?p=<?= $i ?>" class="page-link <?= $i === $page ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if($page < $total_pages): ?>
            <a href="catalogue.php?p=<?= $page + 1 ?>" class="page-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
