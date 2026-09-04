<?php
// index.php
require_once 'config/database.php';

// Fetch 4 recent available items
$stmt = $pdo->query("SELECT clothing_id, name, price, image, size FROM clothing WHERE status = 'available' ORDER BY created_at DESC LIMIT 4");
$featured_items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-Loved Marketplace | Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <header>
        <nav>
            <h1>Pre-Loved Clothing</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="catalog.php">Catalog</a></li>
                <li><a href="cart.php">Cart</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h2>Find Unique Pre-Owned Fashion</h2>
            <p>Shop sustainable, quality clothing directly from independent sellers.</p>
        </section>

        <section>
            <h2>Featured Items</h2>
            <div class="grid">
                <?php foreach ($featured_items as $item): ?>
                    <article class="card">
                        <img src="assets/images/<?= htmlspecialchars($item['image'] ?? 'placeholder.jpg') ?>" 
                             alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="card-body">
                            <h3 class="card-title"><?= htmlspecialchars($item['name']) ?></h3>
                            <p>Size: <?= htmlspecialchars($item['size']) ?></p>
                            <p class="card-price">$<?= number_format($item['price'], 2) ?></p>
                            <a href="product.php?id=<?= $item['clothing_id'] ?>" class="btn">View Details</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Pre-Loved Clothing Marketplace. All rights reserved.</p>
    </footer>

</body>
</html>