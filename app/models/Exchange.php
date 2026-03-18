<?php

class Exchange {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Process a point exchange transaction.
     */
    public function processExchange($userId, $exchangeCart) {
        try {
            $this->db->beginTransaction();

            foreach ($exchangeCart as $item) {
                $exchangeProductId = $item['id'];
                $quantity = $item['quantity'];
                $pointsPerItem = $item['points'];
                $totalPointsSpent = $pointsPerItem * $quantity;

                // 1. Double check user's current balance
                $balanceStmt = $this->db->prepare("SELECT point_balance FROM users WHERE user_id = ? FOR UPDATE");
                $balanceStmt->execute([$userId]);
                $user = $balanceStmt->fetch(PDO::FETCH_ASSOC);

                if (!$user || $user['point_balance'] < $totalPointsSpent) {
                    throw new Exception("Insufficient points for " . $item['name']);
                }

                // 2. Check stock
                $stockStmt = $this->db->prepare("SELECT stock_quantity FROM exchange_products WHERE exchange_product_id = ? FOR UPDATE");
                $stockStmt->execute([$exchangeProductId]);
                $stock = $stockStmt->fetch(PDO::FETCH_ASSOC);

                if (!$stock || $stock['stock_quantity'] < $quantity) {
                    throw new Exception("Insufficient stock for " . $item['name']);
                }

                // 3. Insert into exchanges table
                $insertExchangeStmt = $this->db->prepare("INSERT INTO exchanges (user_id, exchange_product_id, quantity, points_spent, exchange_date) 
                                                           VALUES (?, ?, ?, ?, NOW())");
                $insertExchangeStmt->execute([$userId, $exchangeProductId, $quantity, $totalPointsSpent]);

                // 4. Deduct points from users table
                $updatePointsStmt = $this->db->prepare("UPDATE users SET point_balance = point_balance - ? WHERE user_id = ?");
                $updatePointsStmt->execute([$totalPointsSpent, $userId]);

                // 5. Log to point_transactions
                $logTransStmt = $this->db->prepare("INSERT INTO point_transactions (user_id, points, transaction_type, transaction_date) 
                                                    VALUES (?, ?, 'Redeemed', NOW())");
                $logTransStmt->execute([$userId, $totalPointsSpent]);

                // 6. Update stock_quantity in exchange_products
                $updateStockStmt = $this->db->prepare("UPDATE exchange_products SET stock_quantity = stock_quantity - ? WHERE exchange_product_id = ?");
                $updateStockStmt->execute([$quantity, $exchangeProductId]);
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Exchange transaction failed: " . $e->getMessage());
            return $e->getMessage();
        }
    }

    /**
     * Get user's current point balance.
     */
    public function getUserPoints($userId) {
        $stmt = $this->db->prepare("SELECT point_balance FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['point_balance'] : 0;
    }
}
