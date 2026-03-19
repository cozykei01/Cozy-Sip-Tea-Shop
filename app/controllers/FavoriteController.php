<?php

require_once '../app/models/Favorite.php';
require_once '../app/models/Product.php';
require_once '../app/models/Notification.php';

class FavoriteController {
    private $favoriteModel;
    private $productModel;
    private $notificationModel;

    public function __construct($db) {
        $this->favoriteModel = new Favorite($db);
        $this->productModel = new Product($db);
        $this->notificationModel = new Notification($db);
    }

    /**
     * Toggle heart status for a product via AJAX
     */
    public function toggle() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            return;
        }

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please login to favorite products.']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);
        $productId = $input['productId'] ?? null;
        $userId = $_SESSION['user_id'];

        if (!$productId) {
            echo json_encode(['success' => false, 'message' => 'Product ID is required']);
            return;
        }

        $result = $this->favoriteModel->toggle($userId, $productId);

        if ($result !== false) {
            $productName = '';
            if ($result === 'added') {
                $product = $this->productModel->getProductById($productId);
                $productName = $product ? $product['product_name'] : 'Product';
                
                // Create persistent notification
                $this->notificationModel->create(
                    $userId, 
                    "Product Favorited", 
                    "You added $productName to favorite"
                );
            }

            echo json_encode([
                'success' => true, 
                'status' => $result, 
                'product_name' => $productName,
                'message' => $result === 'added' ? "You added $productName to favorite" : 'Removed from favorites'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Operation failed']);
        }
    }

    /**
     * Get all favorite product IDs for the current user
     */
    public function getFavorites() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => true, 'favorites' => []]);
            return;
        }

        $favorites = $this->favoriteModel->getUserFavoriteIds($_SESSION['user_id']);
        echo json_encode(['success' => true, 'favorites' => $favorites]);
    }
}
