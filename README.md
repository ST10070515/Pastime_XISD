# Pre-Loved Clothing Marketplace

A lightweight PHP and MySQL marketplace for browsing and collecting unique pre-owned clothing items. The application presents available listings, supports category filtering, shows seller and item details, and stores a one-item-per-listing shopping cart in the PHP session.

## Current Status

The browsing and cart flows are implemented. The following parts are present as placeholders or dependencies that still need implementation before the application is production-ready:

- `login.php` and `register.php` are empty.
- `product-details.php` is empty; product details are currently served by `product.php`.
- `cart.php` links to `checkout.php`, but that file is not currently included.
- No database schema or seed SQL file is included in the repository.
- `assets/images/` is currently empty, so listings need uploaded images or a `placeholder.jpg` fallback.
- There is no seller/admin workflow for creating or managing listings.

## Features

- Home page with the four newest available listings.
- Catalog page with filters for Jackets, Shirts, and Pants.
- Product page with price, category, size, condition, description, and seller username.
- Session-based cart for adding and removing unique clothing pieces.
- PDO database access with exceptions, associative fetches, and native prepared statements.
- HTML escaping for listing content rendered into the page.
- Responsive card-grid layout using the shared stylesheet.

## Technology

- PHP 7.4+ or PHP 8.x
- MySQL 5.7+ or MariaDB 10.4+
- PDO with the MySQL driver (`pdo_mysql`)
- HTML5 and CSS3
- Apache, such as the server included with XAMPP, or PHP's built-in development server

## Project Structure

```text
.
|-- Index.php                 Home page and featured listings
|-- catalog.php               Available listings and category filter
|-- product.php               Listing details and add-to-cart action
|-- cart.php                  Session cart display and updates
|-- login.php                 Placeholder for authentication
|-- register.php              Placeholder for account registration
|-- product-details.php       Placeholder page
|-- config/
|   `-- database.php           PDO connection and session initialization
|-- assets/
|   |-- css/
|   |   `-- style.css          Shared site styles
|   |-- images/                Listing images
|   `-- js/
|       `-- main.js            Frontend JavaScript entry point
`-- docs/                      Project documentation
```

## Prerequisites

Install or enable the following before running the application:

1. PHP with the `pdo_mysql` extension.
2. MySQL or MariaDB.
3. A web server capable of serving PHP, or the PHP CLI development server.

Verify PHP and the required extension with:

```bash
php -v
php -m | findstr /I pdo_mysql
```

On macOS or Linux, replace the second command with:

```bash
php -m | grep -i pdo_mysql
```

## Database Setup

The default connection in `config/database.php` expects:

| Setting | Default value |
| --- | --- |
| Host | `127.0.0.1` |
| Database | `clothing_marketplace` |
| Username | `root` |
| Password | empty |
| Character set | `utf8mb4` |

Create the database first:

```sql
CREATE DATABASE clothing_marketplace
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

The current PHP queries require at least these tables and columns:

- `users`: `user_id`, `username`
- `clothing`: `clothing_id`, `seller_id`, `name`, `price`, `image`, `size`, `category`, `item_condition`, `description`, `status`, `created_at`

The `clothing.seller_id` column should reference `users.user_id`. Available listings must use `status = 'available'`. Because the repository does not yet contain a schema file, create these tables or add an approved SQL migration before launching the application.

Update the connection variables in `config/database.php` when your local MySQL credentials differ from the defaults. Do not commit production credentials to source control.

## Run Locally

From the project root, start PHP's built-in server:

```bash
php -S localhost:8000
```

Open [http://localhost:8000/Index.php](http://localhost:8000/Index.php) in a browser.

With XAMPP, copy or link the project into the `htdocs` directory, start Apache and MySQL, then open:

```text
http://localhost/Pastime_XISD/Index.php
```

The project currently uses `Index.php` with an uppercase `I`, while internal links use `index.php`. This works on case-insensitive Windows filesystems, but the filename and links should be normalized before deployment to a case-sensitive server.

## User Flow

1. Visit the home page to see the four newest available items.
2. Open the catalog and optionally filter by category.
3. Select a listing to view its seller and item information.
4. Add the listing to the cart. Each unique clothing listing can appear only once.
5. Remove items from the cart or follow the checkout link when checkout is implemented.

## Development Notes

- Cart contents are stored in `$_SESSION['cart']` and are not persisted between sessions.
- Listing IDs are validated as integers before product and cart operations.
- Listing text is escaped with `htmlspecialchars()` before output.
- Category values are passed through prepared statements.
- The current database error path rethrows the PDO exception. For production, log the detailed exception privately and show users a generic error page.
- Add CSRF protection, server-side authorization, password hashing, input validation, and transaction-safe inventory updates when authentication and checkout are implemented.

## Suggested Next Steps

1. Add a versioned SQL schema and seed data.
2. Implement registration and login with `password_hash()` and `password_verify()`.
3. Add seller listing creation, editing, and availability management.
4. Implement checkout and order persistence.
5. Normalize `Index.php` to `index.php` and update all links.
6. Add automated tests for database access, cart actions, authentication, and checkout.

## License

No license has been specified for this project yet.