<?php

class Favorite {
    private $conn;
    private $table_name = "favorites";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Toggle a favorite status for a user and product
     * Returns 'added', 'removed', or false on failure
     */
    public function toggle($userId, $productId) {
        // Check if exists
        $query = "SELECT favorite_id FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":product_id", $productId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Remove
            $query = "DELETE FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":product_id", $productId);
            if ($stmt->execute()) {
                return 'removed';
            }
        } else {
            // Add
            $query = "INSERT INTO " . $this->table_name . " (user_id, product_id) VALUES (:user_id, :product_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":product_id", $productId);
            if ($stmt->execute()) {
                return 'added';
            }
        }
        return false;
    }

    /**
     * Get all favorite product IDs for a user
     */
    public function getUserFavoriteIds($userId) {
        $query = "SELECT product_id FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    /**
     * Get all favorite products for a user with full details
     */
    public function getUserFavorites($userId) {
        $query = "SELECT p.*, f.created_at as favorited_at 
                  FROM " . $this->table_name . " f
                  JOIN products p ON f.product_id = p.product_id
                  WHERE f.user_id = :user_id
                  ORDER BY f.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
