<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$products = [
    1  => ['id' => 1,  'name' => 'Vintage Zip-Up',       'category' => 'Jackets',    'price' => 89,  'stock' => 12, 'sizes' => ['XS','S','M','L','XL','XXL'], 'colors' => ['#1a1a1a','#5C4033','#3B5B3B'], 'desc' => 'Classic zip-up hoodie with a worn-in look. Brushed fleece interior for extra warmth.'],
    2  => ['id' => 2,  'name' => 'Oversized Tee',         'category' => 'T-Shirts',   'price' => 39,  'stock' => 30, 'sizes' => ['XS','S','M','L','XL','XXL'], 'colors' => ['#FFFFFF','#000000','#C8A87A'], 'desc' => 'Heavyweight 240gsm cotton tee. Drop-shoulder relaxed fit. A wardrobe essential.'],
    3  => ['id' => 3,  'name' => 'Cargo Pants',           'category' => 'Bottoms',    'price' => 99,  'stock' => 8,  'sizes' => ['XS','S','M','L','XL','XXL'], 'colors' => ['#4B5320','#5C4033','#1a1a1a'], 'desc' => 'Wide-leg cargo pants with 6 deep pockets. Adjustable waistband for a custom fit.'],
    4  => ['id' => 4,  'name' => 'Street Beanie',         'category' => 'Accessories','price' => 29,  'stock' => 25, 'sizes' => ['One Size'],                   'colors' => ['#1a1a1a','#FFFFFF','#C8A87A'], 'desc' => 'Ribbed knit beanie with a slouchy fit. One size fits all.'],
    5  => ['id' => 5,  'name' => 'Puffer Jacket',         'category' => 'Jackets',    'price' => 149, 'stock' => 5,  'sizes' => ['S','M','L','XL'],             'colors' => ['#1a1a1a','#2F4F4F'],           'desc' => 'Water-resistant puffer jacket with recycled fill. Packable into its own pocket.'],
    6  => ['id' => 6,  'name' => 'Heavyweight Hoodie',    'category' => 'Hoodies',    'price' => 79,  'stock' => 20, 'sizes' => ['XS','S','M','L','XL','XXL'], 'colors' => ['#3D2B1F','#1a1a1a','#4B5320'], 'desc' => 'Double-lined hood with kangaroo pocket. 380gsm French terry.'],
    7  => ['id' => 7,  'name' => 'Denim Jeans',           'category' => 'Bottoms',    'price' => 109, 'stock' => 10, 'sizes' => ['28','30','32','34','36'],      'colors' => ['#4A6FA5','#1a1a1a'],           'desc' => 'Straight-cut denim with slight stretch for comfort. Raw hem finish.'],
    8  => ['id' => 8,  'name' => 'Graphic Longsleeve',    'category' => 'T-Shirts',   'price' => 49,  'stock' => 18, 'sizes' => ['XS','S','M','L','XL','XXL'], 'colors' => ['#FFFFFF','#1a1a1a'],           'desc' => 'Screen-printed graphic longsleeve. Relaxed boxy fit on 200gsm cotton.'],
    9  => ['id' => 9,  'name' => 'Varsity Jacket',        'category' => 'Jackets',    'price' => 129, 'stock' => 6,  'sizes' => ['S','M','L','XL'],             'colors' => ['#1a1a1a','#8B0000'],           'desc' => 'Wool-blend varsity jacket with leather sleeves. Embroidered logo on chest.'],
    10 => ['id' => 10, 'name' => 'Low-Top Sneakers',      'category' => 'Footwear',   'price' => 119, 'stock' => 9,  'sizes' => ['39','40','41','42','43','44'], 'colors' => ['#FFFFFF','#1a1a1a'],           'desc' => 'Canvas low-top with vulcanized rubber sole. Comfortable all-day wear.'],
];

function getCartTotal() {
    global $products;
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $products[$item['product_id']]['price'] * $item['qty'];
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
