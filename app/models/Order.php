<?php

class Order {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Create a new order with multiple related records in a single transaction.
     */
    public function createOrder($userId, $cart, $totalAmount, $totalQuantity, $earnedPoints, $paymentMethod) {
        try {
            $this->db->beginTransaction();

            // 1. Insert into orders table
            $stmt = $this->db->prepare("INSERT INTO orders (user_id, total_quantity, earned_points, total_amount, order_date) 
                                        VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$userId, $totalQuantity, $earnedPoints, $totalAmount]);
            $orderId = $this->db->lastInsertId();

            // 2. Insert into order_details table
            $detailStmt = $this->db->prepare("INSERT INTO order_details (order_id, product_id, quantity, unit_price, total_amount) 
                                              VALUES (?, ?, ?, ?, ?)");
            foreach ($cart as $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                $detailStmt->execute([
                    $orderId, 
                    $item['id'], 
                    $item['quantity'], 
                    $item['price'], 
                    $itemTotal
                ]);

                // Optional: Update product stock in products table
                $updateStockStmt = $this->db->prepare("UPDATE products SET quantity = quantity - ? WHERE product_id = ?");
                $updateStockStmt->execute([$item['quantity'], $item['id']]);
            }

            // 3. Insert into payments table
            $paymentStmt = $this->db->prepare("INSERT INTO payments (order_id, payment_method, payment_status, payment_date) 
                                               VALUES (?, ?, 'Completed', NOW())");
            $paymentStmt->execute([$orderId, $paymentMethod]);

            // 4. Update user's point balance
            $updatePointsStmt = $this->db->prepare("UPDATE users SET point_balance = point_balance + ? WHERE user_id = ?");
            $updatePointsStmt->execute([$earnedPoints, $userId]);

            // 5. Insert into point_transactions table
            $pointTransStmt = $this->db->prepare("INSERT INTO point_transactions (user_id, order_id, points, transaction_type, transaction_date) 
                                                  VALUES (?, ?, ?, 'Earned', NOW())");
            $pointTransStmt->execute([$userId, $orderId, $earnedPoints]);

            $this->db->commit();
            return $orderId;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Order creation failed: " . $e->getMessage());
            return false;
        }
    }
    /**
     * Get order history for a user
     */
    public function getOrdersByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
