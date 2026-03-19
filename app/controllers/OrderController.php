<?php

require_once '../app/models/Order.php';

class OrderController {
    private $orderModel;

    public function __construct($db) {
        $this->orderModel = new Order($db);
    }

    public function store() {
        // Ensure request is POST and user is logged in
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
            return;
        }

        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please login to continue']);
            return;
        }

        // Get POST data
        $input = json_decode(file_get_contents('php://input'), true);
        
        $cart = $input['cart'] ?? [];
        $paymentMethod = $input['payment_method'] ?? '';
        $totalAmount = $input['total_amount'] ?? 0;
        $totalQuantity = $input['total_quantity'] ?? 0;
        $earnedPoints = $input['earned_points'] ?? 0;
        $userId = $_SESSION['user_id'];

        if (empty($cart) || empty($paymentMethod)) {
            echo json_encode(['success' => false, 'message' => 'Invalid order data']);
            return;
        }

        try {
            // Create Order
            $orderId = $this->orderModel->createOrder(
                $userId, 
                $cart, 
                $totalAmount, 
                $totalQuantity, 
                $earnedPoints, 
                $paymentMethod
            );

            if ($orderId) {
                // Update session points
                $_SESSION['user_points'] = ($_SESSION['user_points'] ?? 0) + $earnedPoints;
                
                // Create notification (Non-blocking if possible)
                try {
                    require_once '../app/models/Notification.php';
                    $notification = new Notification($this->orderModel->getConnection());
                    $dateStr = date('M d, Y | h:i A');
                    $notification->create($userId, 'Payment Successful', "Your order #$orderId has been successfully placed at $dateStr.");
                    $unreadCount = $notification->countUnread($userId);
                } catch (Exception $e) {
                    $unreadCount = 0;
                }

                echo json_encode([
                    'success' => true, 
                    'message' => 'Payment Successful!', 
                    'order_id' => $orderId,
                    'new_points' => $_SESSION['user_points'],
                    'unread_count' => $unreadCount
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to process order. Please try again.']);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Internal server error: ' . $e->getMessage()]);
        }
    }
}
