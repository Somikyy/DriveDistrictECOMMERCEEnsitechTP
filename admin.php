<?php require_once 'header.php'; 
if (!isAdmin()) {
    header('Location: index.php');
    exit;
}
?>
<main style="display:flex; flex-direction:column; align-items:center; width:100%; max-width:1200px; margin:0 auto; padding:0 20px 40px; gap:30px; flex:1;">
    <div style="width:100%; display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
        <h2 style="font-size:3.5rem;">Admin Dashboard</h2>
        <a href="admin_edit.php" class="buy-button" style="width:auto; padding:10px 25px; font-size:1.8rem; background-color:#9BD576;">+ Add Product</a>
    </div>

    <div style="width:100%; border:2px solid #1a1a1a; border-radius:20px; box-shadow:6px 6px 0px #1a1a1a; overflow:hidden; background-color:#f7f3e8;">
        <table style="width:100%; border-collapse:collapse; font-size:1.6rem;">
            <thead style="background-color:#FFBB7F; border-bottom:2px solid #1a1a1a;">
                <tr>
                    <th style="padding:15px; text-align:left;">Product</th>
                    <th style="padding:15px; text-align:left;">Category</th>
                    <th style="padding:15px; text-align:right;">Price</th>
                    <th style="padding:15px; text-align:right;">Stock</th>
                    <th style="padding:15px; text-align:center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $p): ?>
                <tr style="border-bottom:1px solid #1a1a1a;">
                    <td style="padding:15px; display:flex; align-items:center; gap:15px;">
                        <div style="width:50px; height:50px; border:1px solid #1a1a1a; border-radius:8px; background-image:url('<?= $p['image'] ?>'); background-size:cover; background-position:center;"></div>
                        <strong><?= $p['name'] ?></strong>
                    </td>
                    <td style="padding:15px;"><?= $p['category'] ?></td>
                    <td style="padding:15px; text-align:right;">$<?= number_format($p['price'], 2) ?></td>
                    <td style="padding:15px; text-align:right; font-weight:bold; color: <?= $p['stock'] < 5 ? '#ff6b6b' : 'inherit' ?>;">
                        <?= $p['stock'] ?>
                    </td>
                    <td style="padding:15px; text-align:center;">
                        <div style="display:flex; gap:10px; justify-content:center;">
                            <a href="admin_edit.php?id=<?= $p['id'] ?>" class="nav-link" style="padding:5px 15px; font-size:1.4rem; background-color:#f7f3e8;">Edit</a>
                            <form method="POST" action="admin_actions.php" onsubmit="return confirm('Delete this product?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button type="submit" class="remove-button" style="font-size:1.4rem;">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<?php include 'footer.php'; ?>
