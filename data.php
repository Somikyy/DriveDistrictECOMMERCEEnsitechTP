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

// Insert initial products if the table is empty
$stmt = $pdo->query("SELECT COUNT(*) FROM products");
if ($stmt->fetchColumn() == 0) {
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

// Global products array to maintain compatibility with existing project
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
