<?php
session_start();
require_once '../app/config/database.php';
require_once '../app/models/Product.php';

$database = new Database();
$db = $database->getConnection();
$productModel = new Product($db);

// Handle Process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save') {
    $data = [
        'category_id' => $_POST['category_id'],
        'product_name' => $_POST['product_name'],
        'quantity' => $_POST['quantity'],
        'price' => $_POST['price'],
        'event_price' => !empty($_POST['event_price']) ? $_POST['event_price'] : 0,
        'earned_point_value' => !empty($_POST['earned_point_value']) ? $_POST['earned_point_value'] : 0,
        'event_status' => isset($_POST['event_status']) ? 1 : 0
    ];

    $result = $productModel->create($data);

    if ($result) {
        $_SESSION['success'] = "Product created successfully! ID: $result";
    } else {
        $_SESSION['error'] = "Failed to create product.";
    }
    header("Location: add-items.php");
    exit();
}

$categories = $productModel->getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product (Standalone) - Cozy Sip</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --cozy-green: #004225;
            --cozy-sage: #F1F8F5;
            --cozy-text: #2D3E33;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--cozy-sage);
            color: var(--cozy-text);
            margin: 0;
            padding: 0;
        }
        .admin-hero {
            padding: 6rem 2rem 10rem;
            background: linear-gradient(rgba(11, 38, 17, 0.85), rgba(11, 38, 17, 0.85)), url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
            text-align: center;
            color: white;
        }
        .container {
            max-width: 800px;
            margin: -6rem auto 4rem;
            padding: 3rem;
            background: white;
            border-radius: 2rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        .form-group { margin-bottom: 1.5rem; }
        .form-group.full-width { grid-column: span 2; }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--cozy-green);
            font-size: 0.9rem;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 0.8rem 1.2rem;
            border: 1px solid #ddd;
            border-radius: 1rem;
            font-size: 1rem;
            box-sizing: border-box;
        }
        .submit-btn {
            grid-column: span 2;
            padding: 1.2rem;
            background: var(--cozy-green);
            color: white;
            border: none;
            border-radius: 1rem;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        .submit-btn:hover { background: #002d19; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0, 66, 37, 0.2); }
        .alert {
            padding: 1.2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            text-align: center;
            font-weight: 600;
        }
        .alert-success { background: #dcfce7; color: #166534; }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .checkbox-group { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; }
        .checkbox-group input { width: auto; }
        .back-link {
            display: inline-block;
            margin-top: 2rem;
            color: var(--cozy-green);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <header class="admin-hero">
        <h1>Standalone Product Adder</h1>
        <p>This file is invisible to the main site routing.</p>
    </header>

    <main class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-check-circle"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="add-items.php" method="POST">
            <input type="hidden" name="action" value="save">
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="product_name" placeholder="e.g. Honey Jasmine Tea" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Select a category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['product_category_id']; ?>">
                                <?php echo htmlspecialchars($cat['product_category_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Initial Quantity (Stock)</label>
                    <input type="number" id="quantity" name="quantity" value="100" min="0" required>
                </div>

                <div class="form-group">
                    <label for="price">Standard Price (Ks)</label>
                    <input type="number" id="price" name="price" placeholder="4500" min="0" required>
                </div>

                <div class="form-group">
                    <label for="event_price">Event Price (Optional - Ks)</label>
                    <input type="number" id="event_price" name="event_price" placeholder="4000" min="0">
                </div>

                <div class="form-group">
                    <label for="earned_point_value">Points Earned per Purchase</label>
                    <input type="number" id="earned_point_value" name="earned_point_value" value="100" min="0">
                </div>

                <div class="form-group">
                    <label class="checkbox-group">
                        <input type="checkbox" name="event_status" value="1">
                        Show in Event Products (Home Page)
                    </label>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-plus"></i> Add Product to Database
                </button>
            </div>
        </form>
        
        <a href="index.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back to Main Site</a>
    </main>
</body>
</html>
