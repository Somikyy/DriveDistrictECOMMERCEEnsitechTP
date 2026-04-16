<?php require_once 'header.php'; 
if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$p = $id > 0 ? $products[$id] : [
    'name' => '',
    'category' => '',
    'price' => '',
    'stock' => '',
    'desc' => '',
    'image' => '',
    'sizes' => [],
    'colors' => []
];

// Comma-separated strings for the form
$sizes_str = implode(', ', $p['sizes']);
$colors_str = implode(', ', $p['colors']);
?>
<main style="display:flex; flex-direction:column; align-items:center; width:100%; max-width:800px; margin:0 auto; padding:0 20px 40px; gap:30px; flex:1;">
    <div style="width:100%; display:flex; align-items:center; gap:20px; margin-top:20px;">
        <a href="admin.php" class="nav-link" style="padding:10px 20px; font-size:1.6rem;">← Back</a>
        <h2 style="font-size:3.5rem;"><?= $id > 0 ? 'Edit' : 'Add' ?> Product</h2>
    </div>

    <form method="POST" action="admin_actions.php" style="width:100%; border:2px solid #1a1a1a; border-radius:30px; box-shadow:8px 8px 0px #1a1a1a; background-color:#f7f3e8; padding:40px; display:flex; flex-direction:column; gap:25px;">
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="id" value="<?= $id ?>">

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
            <div style="display:flex; flex-direction:column; gap:8px;">
                <label style="font-size:1.8rem; font-weight:bold;">Product Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($p['name']) ?>" required style="padding:15px; border:2px solid #1a1a1a; border-radius:12px; font-size:1.6rem; background:#fff; box-shadow:2px 2px 0px #1a1a1a;">
            </div>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <label style="font-size:1.8rem; font-weight:bold;">Category</label>
                <select name="category" required style="padding:15px; border:2px solid #1a1a1a; border-radius:12px; font-size:1.6rem; background:#fff; box-shadow:2px 2px 0px #1a1a1a;">
                    <option value="Jackets" <?= $p['category'] === 'Jackets' ? 'selected' : '' ?>>Jackets</option>
                    <option value="T-Shirts" <?= $p['category'] === 'T-Shirts' ? 'selected' : '' ?>>T-Shirts</option>
                    <option value="Bottoms" <?= $p['category'] === 'Bottoms' ? 'selected' : '' ?>>Bottoms</option>
                    <option value="Hoodies" <?= $p['category'] === 'Hoodies' ? 'selected' : '' ?>>Hoodies</option>
                    <option value="Accessories" <?= $p['category'] === 'Accessories' ? 'selected' : '' ?>>Accessories</option>
                    <option value="Footwear" <?= $p['category'] === 'Footwear' ? 'selected' : '' ?>>Footwear</option>
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
            <div style="display:flex; flex-direction:column; gap:8px;">
                <label style="font-size:1.8rem; font-weight:bold;">Price ($)</label>
                <input type="number" step="0.01" name="price" value="<?= $p['price'] ?>" required style="padding:15px; border:2px solid #1a1a1a; border-radius:12px; font-size:1.6rem; background:#fff; box-shadow:2px 2px 0px #1a1a1a;">
            </div>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <label style="font-size:1.8rem; font-weight:bold;">Stock Quantity</label>
                <input type="number" name="stock" value="<?= $p['stock'] ?>" required style="padding:15px; border:2px solid #1a1a1a; border-radius:12px; font-size:1.6rem; background:#fff; box-shadow:2px 2px 0px #1a1a1a;">
            </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
            <div style="display:flex; flex-direction:column; gap:8px;">
                <label style="font-size:1.8rem; font-weight:bold;">Sizes (comma separated)</label>
                <input type="text" name="sizes" value="<?= htmlspecialchars($sizes_str) ?>" placeholder="S, M, L, XL" style="padding:15px; border:2px solid #1a1a1a; border-radius:12px; font-size:1.6rem; background:#fff; box-shadow:2px 2px 0px #1a1a1a;">
            </div>
            <div style="display:flex; flex-direction:column; gap:8px;">
                <label style="font-size:1.8rem; font-weight:bold;">Colors (Hex or name, comma separated)</label>
                <input type="text" name="colors" value="<?= htmlspecialchars($colors_str) ?>" placeholder="#000000, #FFFFFF" style="padding:15px; border:2px solid #1a1a1a; border-radius:12px; font-size:1.6rem; background:#fff; box-shadow:2px 2px 0px #1a1a1a;">
            </div>
        </div>

        <div style="display:flex; flex-direction:column; gap:8px;">
            <label style="font-size:1.8rem; font-weight:bold;">Image URL</label>
            <input type="url" name="image" value="<?= htmlspecialchars($p['image'] ?? '') ?>" style="padding:15px; border:2px solid #1a1a1a; border-radius:12px; font-size:1.6rem; background:#fff; box-shadow:2px 2px 0px #1a1a1a;">
        </div>

        <div style="display:flex; flex-direction:column; gap:8px;">
            <label style="font-size:1.8rem; font-weight:bold;">Description</label>
            <textarea name="desc" rows="4" style="padding:15px; border:2px solid #1a1a1a; border-radius:12px; font-size:1.6rem; background:#fff; box-shadow:2px 2px 0px #1a1a1a; font-family:inherit;"><?= htmlspecialchars($p['desc']) ?></textarea>
        </div>

        <button type="submit" class="pay-safe-btn" style="margin-top:10px;"><?= $id > 0 ? 'Update' : 'Create' ?> Product</button>
    </form>
</main>
<?php include 'footer.php'; ?>
