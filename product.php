<?php
// product.php
require_once 'config/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: catalog.php");
    exit();
}

$stmt = $pdo->prepare("SELECT c.*, u.username FROM clothing c JOIN users u ON c.seller_id = u.user_id WHERE c.clothing_id = :id AND c.status = 'available'");
$stmt->execute(['id' => $id]);
$item = $stmt->fetch();

if (!$item) {
    echo "Product not found or unavailable.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($item['name']) ?> | Pre-Loved Marketplace</title>
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
        <article style="display: flex; gap: 2rem; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <img src="assets/images/<?= htmlspecialchars($item['image'] ?? 'placeholder.jpg') ?>" 
                     alt="<?= htmlspecialchars($item['name']) ?>" style="width: 100%; border-radius: 6px;">
            </div>
            <div style="flex: 1; min-width: 300px;">
                <h2><?= htmlspecialchars($item['name']) ?></h2>
                <p class="card-price" style="font-size: 1.5rem;">$<?= number_format($item['price'], 2) ?></p>
                <p><strong>Seller:</strong> <?= htmlspecialchars($item['username']) ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($item['category']) ?></p>
                <p><strong>Size:</strong> <?= htmlspecialchars($item['size']) ?></p>
                <p><strong>Condition:</strong> <?= htmlspecialchars($item['item_condition']) ?></p>
                <p style="margin: 1rem 0;"><?= nl2br(htmlspecialchars($item['description'])) ?></p>

                <form action="cart.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="clothing_id" value="<?= $item['clothing_id'] ?>">
                    <button type="submit" class="btn">Add to Cart</button>
                </form>
            </div>
        </article>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Pre-Loved Clothing Marketplace. All rights reserved.</p>
    </footer>

</body>
</html>