<?php include 'header.php'; ?>

<main class="faq-grid">
    <?php 
    $faqs = [
        ['q' => 'How long does shipping take?',           'a' => 'Standard shipping takes 3-5 business days. Express shipping (1-2 days) is available at checkout for an extra fee.'],
        ['q' => 'Do you ship internationally?',           'a' => 'Yes! We ship worldwide. International delivery takes 7-14 business days depending on your location.'],
        ['q' => 'How do I track my order?',               'a' => 'Once your order ships, you\'ll receive an email with a tracking link. You can also check your order status on our carrier\'s website.'],
        ['q' => 'Can I return or exchange an item?',      'a' => 'We accept returns within 30 days of delivery. Items must be unworn and in original packaging. Exchanges for a different size are free!'],
    ];
    foreach($faqs as $faq): ?>
    <details class="faq-card" style="cursor:pointer; user-select:none; flex-direction:column; align-items:flex-start; gap:15px;">
        <summary style="list-style:none; width:100%; text-align:center; font-size:2.5rem;"><?= $faq['q'] ?></summary>
        <p style="font-size:1.8rem; font-family: sans-serif; font-weight:normal; text-align:center; width:100%; padding: 0 20px 10px;"><?= $faq['a'] ?></p>
    </details>
    <?php endforeach; ?>
</main>

<?php include 'footer.php'; ?>
