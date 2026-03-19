<?php
class Product {
    private $conn;
    private $table_name = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getProductsByCategory($category_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventProducts(int $limit = 4) {
        $query = "SELECT p.*, pc.product_category_name 
                  FROM products p
                  LEFT JOIN product_categories pc ON p.category_id = pc.product_category_id
                  WHERE p.event_status = 1";
        
        if ($limit > 0) {
            $query .= " LIMIT " . (int)$limit;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getExchangeProducts() {
        $query = "SELECT p.*, ep.points_required, ep.stock_quantity, ep.exchange_product_id
                  FROM products p
                  JOIN exchange_products ep ON p.product_id = ep.product_id
                  WHERE ep.is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * Get a single product by ID
     */
    public function getProductById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE product_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /**
     * Get all categories
     */
    public function getCategories() {
        $query = "SELECT * FROM product_categories ORDER BY product_category_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new product
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (category_id, product_name, quantity, price, event_price, earned_point_value, event_status) 
                  VALUES (:category_id, :product_name, :quantity, :price, :event_price, :earned_point_value, :event_status)";
        
        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(":category_id", $data['category_id']);
        $stmt->bindParam(":product_name", $data['product_name']);
        $stmt->bindParam(":quantity", $data['quantity']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":event_price", $data['event_price']);
        $stmt->bindParam(":earned_point_value", $data['earned_point_value']);
        $stmt->bindParam(":event_status", $data['event_status']);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
}
