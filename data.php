<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$db_file = __DIR__ . '/drivedistrict.sqlite';
$pdo = new PDO('sqlite:' . $db_file);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("
    CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        category TEXT NOT NULL,
        price REAL NOT NULL,
        stock INTEGER NOT NULL,
        sizes TEXT NOT NULL,
        colors TEXT NOT NULL,
        desc TEXT NOT NULL
    );
    
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        role TEXT NOT NULL DEFAULT 'user',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
    
    CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        total REAL NOT NULL,
        status TEXT NOT NULL DEFAULT 'pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
    
    CREATE TABLE IF NOT EXISTS order_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_id INTEGER NOT NULL,
        product_id INTEGER NOT NULL,
        size TEXT NOT NULL,
        qty INTEGER NOT NULL,
        price REAL NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id),
        FOREIGN KEY (product_id) REFERENCES products(id)
    );
");

// Database upgrades
try {
    $pdo->exec("ALTER TABLE products ADD COLUMN image TEXT DEFAULT ''");
    $img_urls = [
        1 => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=400',
        2 => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=400',
        3 => 'https://images.unsplash.com/photo-1624378439575-d1ead6bb246b?q=80&w=400',
        4 => 'https://images.unsplash.com/photo-1576871337622-98d48d1cf531?q=80&w=400',
        5 => 'https://images.unsplash.com/photo-1559551409-dadc959f76b8?q=80&w=400',
        6 => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=400',
        7 => 'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=400',
        8 => 'https://images.unsplash.com/photo-1618517351616-389a7ac72579?q=80&w=400',
        9 => 'https://images.unsplash.com/photo-1551028719-0c14457cc7dc?q=80&w=400',
        10 => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=400'
    ];
    foreach($img_urls as $id => $url) {
        $pdo->exec("UPDATE products SET image = '$url' WHERE id = $id AND (image IS NULL OR image = '')");
    }
} catch (Exception $e) {}

try {
    $pdo->exec("ALTER TABLE users ADD COLUMN cart TEXT DEFAULT '[]'");
} catch (Exception $e) {}

try {
    $pdo->exec("ALTER TABLE users ADD COLUMN role TEXT DEFAULT 'user'");
} catch (Exception $e) {}

// Ensure default admin exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute(['admin']);
if (!$stmt->fetch()) {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute(['admin', 'admin@drivedistrict.com', password_hash('admin123', PASSWORD_DEFAULT), 'admin']);
}

// Initial products insertion with blank image if somehow tables were dropped
$stmt = $pdo->query("SELECT COUNT(*) FROM products");
if ($stmt->fetchColumn() == 0) {
    // Note: The images will be patched by the alter script or handled on next reload, keeping it simple.
    $initial_products = [
        ['Vintage Zip-Up', 'Jackets', 89, 12, '["XS","S","M","L","XL","XXL"]', '["#1a1a1a","#5C4033","#3B5B3B"]', 'Classic zip-up hoodie with a worn-in look. Brushed fleece interior for extra warmth.'],
        ['Oversized Tee', 'T-Shirts', 39, 30, '["XS","S","M","L","XL","XXL"]', '["#FFFFFF","#000000","#C8A87A"]', 'Heavyweight 240gsm cotton tee. Drop-shoulder relaxed fit. A wardrobe essential.'],
        ['Cargo Pants', 'Bottoms', 99, 8, '["XS","S","M","L","XL","XXL"]', '["#4B5320","#5C4033","#1a1a1a"]', 'Wide-leg cargo pants with 6 deep pockets. Adjustable waistband for a custom fit.'],
        ['Street Beanie', 'Accessories', 29, 25, '["One Size"]', '["#1a1a1a","#FFFFFF","#C8A87A"]', 'Ribbed knit beanie with a slouchy fit. One size fits all.'],
        ['Puffer Jacket', 'Jackets', 149, 5, '["S","M","L","XL"]', '["#1a1a1a","#2F4F4F"]', 'Water-resistant puffer jacket with recycled fill. Packable into its own pocket.'],
        ['Heavyweight Hoodie', 'Hoodies', 79, 20, '["XS","S","M","L","XL","XXL"]', '["#3D2B1F","#1a1a1a","#4B5320"]', 'Double-lined hood with kangaroo pocket. 380gsm French terry.'],
        ['Denim Jeans', 'Bottoms', 109, 10, '["28","30","32","34","36"]', '["#4A6FA5","#1a1a1a"]', 'Straight-cut denim with slight stretch for comfort. Raw hem finish.'],
        ['Graphic Longsleeve', 'T-Shirts', 49, 18, '["XS","S","M","L","XL","XXL"]', '["#FFFFFF","#1a1a1a"]', 'Screen-printed graphic longsleeve. Relaxed boxy fit on 200gsm cotton.'],
        ['Varsity Jacket', 'Jackets', 129, 6, '["S","M","L","XL"]', '["#1a1a1a","#8B0000"]', 'Wool-blend varsity jacket with leather sleeves. Embroidered logo on chest.'],
        ['Low-Top Sneakers', 'Footwear', 119, 9, '["39","40","41","42","43","44"]', '["#FFFFFF","#1a1a1a"]', 'Canvas low-top with vulcanized rubber sole. Comfortable all-day wear.']
    ];
    $insertStmt = $pdo->prepare("INSERT INTO products (name, category, price, stock, sizes, colors, desc) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($initial_products as $p) {
        $insertStmt->execute($p);
    }
}

// Global products array
$products = [];
$stmt = $pdo->query("SELECT * FROM products");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $row['sizes'] = json_decode($row['sizes'], true) ?: [];
    $row['colors'] = json_decode($row['colors'], true) ?: [];
    $products[$row['id']] = $row;
}

function getCartTotal() {
    global $products;
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        if (isset($products[$item['product_id']])) {
            $total += $products[$item['product_id']]['price'] * $item['qty'];
        }
    }
    return $total;
}

function getCartCount() {
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['qty'];
    }
    return $count;
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
