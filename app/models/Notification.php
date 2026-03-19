<?php

class Notification {
    private $conn;
    private $table_name = "notifications";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create a new notification
     */
    public function create($userId, $title, $message) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, title, message) VALUES (:user_id, :title, :message)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":message", $message);
        return $stmt->execute();
    }

    /**
     * Get unread notifications for a user
     */
    public function getUnread($userId, $limit = 5) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE user_id = :user_id AND is_read = 0 
                  ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all notifications for a user
     */
    public function getAll($userId, $limit = 10) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE user_id = :user_id 
                  ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Count unread notifications
     */
    public function countUnread($userId) {
        $query = "SELECT COUNT(*) as unread_count FROM " . $this->table_name . " 
                  WHERE user_id = :user_id AND is_read = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['unread_count'];
    }

    /**
     * Mark all as read
     */
    public function markAllAsRead($userId) {
        $query = "UPDATE " . $this->table_name . " SET is_read = 1 WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        return $stmt->execute();
    }
}
