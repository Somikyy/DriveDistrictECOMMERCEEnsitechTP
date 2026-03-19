<?php include 'header.php'; ?>

<main class="payment-layout">
    <div class="payment-titles">
        <h2>Add some products!<br>Get delivery free!</h2>
    </div>
    
    <div class="payment-products">
        <?php for($i=0; $i<5; $i++): ?>
        <div class="payment-post">
            <h2>Post 1</h2>
        </div>
        <?php endfor; ?>
    </div>
    
    <button class="pay-safe-btn">Pay safe!</button>
</main>

<?php include 'footer.php'; ?>
