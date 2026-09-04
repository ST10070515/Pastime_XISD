<?php
// catalog.php
require_once 'config/database.php';

$category = $_GET['category'] ?? '';

if (!empty($category)) {
    $stmt = $pdo->prepare("SELECT * FROM clothing WHERE status = 'available' AND category = :category ORDER BY created_at DESC");
    $stmt->execute(['category' => $category]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM clothing WHERE status = 'available' ORDER BY created_at DESC");
    $stmt->execute();
}

$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog | Pre-Loved Marketplace</title>
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
        <h2>Browse Clothing</h2>
        
        <form method="GET" action="catalog.php" style="margin-bottom: 1.5rem;">
            <label for="category">Filter by Category:</label>
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <option value="Jackets" <?= $category === 'Jackets' ? 'selected' : '' ?>>Jackets</option>
                <option value="Shirts" <?= $category === 'Shirts' ? 'selected' : '' ?>>Shirts</option>
                <option value="Pants" <?= $category === 'Pants' ? 'selected' : '' ?>>Pants</option>
            </select>
        </form>

        <div class="grid">
            <?php if (empty($items)): ?>
                <p>No items found for this selection.</p>
            <?php else: ?>
                <?php foreach ($items as $item): ?>
                    <article class="card">
                        <img src="assets/images/<?= htmlspecialchars($item['image'] ?? 'placeholder.jpg') ?>" 
                             alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="card-body">
                            <h3 class="card-title"><?= htmlspecialchars($item['name']) ?></h3>
                            <p>Category: <?= htmlspecialchars($item['category']) ?></p>
                            <p>Size: <?= htmlspecialchars($item['size']) ?></p>
                            <p class="card-price">$<?= number_format($item['price'], 2) ?></p>
                            <a href="product.php?id=<?= $item['clothing_id'] ?>" class="btn">View Product</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Pre-Loved Clothing Marketplace. All rights reserved.</p>
    </footer>

</body>
</html>