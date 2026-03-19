<?php include 'header.php'; ?>

<main class="payment-layout">
    <div class="payment-titles">
        <h2>Your Cart total: 178$</h2>
        <h2>Congrats! You get FREE delivery!</h2>
    </div>
    
    <div class="payment-products">
        <?php 
        $items = ["Vintage Zip-Up", "Oversized Tee", "Cargo Pants", "Beanie", "Puffer"];
        foreach($items as $item): ?>
        <div class="payment-post">
            <h2 style="font-size:2rem; text-align:center;"><?= $item ?></h2>
        </div>
        <?php endforeach; ?>
    </div>
    
    <button class="pay-safe-btn">Pay Securely</button>
</main>

<?php include 'footer.php'; ?>
