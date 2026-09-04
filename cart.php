<?php
// cart.php
require_once 'config/database.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle cart updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $clothing_id = filter_input(INPUT_POST, 'clothing_id', FILTER_VALIDATE_INT);
    
    if ($_POST['action'] === 'add' && $clothing_id) {
        $_SESSION['cart'][$clothing_id] = 1; // 1 item per unique clothing piece
    } elseif ($_POST['action'] === 'remove' && $clothing_id) {
        unset($_SESSION['cart'][$clothing_id]);
    }
    
    header("Location: cart.php");
    exit();
}

// Fetch items currently in cart
$cart_items = [];
$total_amount = 0.00;

if (!empty($_SESSION['cart'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['cart']), '?'));
    $stmt = $pdo->prepare("SELECT * FROM clothing WHERE clothing_id IN ($placeholders)");
    $stmt->execute(array_keys($_SESSION['cart']));
    $cart_items = $stmt->fetchAll();

    foreach ($cart_items as $item) {
        $total_amount += $item['price'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | Pre-Loved Marketplace</title>
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
        <h2>Your Shopping Cart</h2>

        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty. <a href="catalog.php">Browse catalog</a>.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= htmlspecialchars($item['size']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <form action="cart.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="clothing_id" value="<?= $item['clothing_id'] ?>">
                                    <button type="submit" class="btn btn-secondary">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="margin-top: 1.5rem; text-align: right;">
                <h3>Total: $<?= number_format($total_amount, 2) ?></h3>
                <a href="checkout.php" class="btn" style="margin-top: 1rem;">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Pre-Loved Clothing Marketplace. All rights reserved.</p>
    </footer>

</body>
</html>