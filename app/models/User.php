<?php
class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Validate registration data
     * @return array|bool Returns an array of errors or true if valid
     */
    public function validate($data) {
        $errors = [];

        // Name validation
        if (empty($data['name'])) {
            $errors['name'] = "Name is required.";
        }

        // Email validation
        if (empty($data['email'])) {
            $errors['email'] = "Email is required.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        } elseif ($this->emailExists($data['email'])) {
            $errors['email'] = "Email already registered.";
        }

        // Password validation
        if (empty($data['password'])) {
            $errors['password'] = "Password is required.";
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = "Password must be at least 6 characters.";
        }

        if ($data['password'] !== $data['confirm_password']) {
            $errors['confirm_password'] = "Passwords do not match.";
        }

        return empty($errors) ? true : $errors;
    }

    /**
     * Check if email already exists
     */
    public function emailExists($email) {
        $query = "SELECT user_id FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /**
     * Create a new user
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_name, full_name, email, password, role) 
                  VALUES (:user_name, :full_name, :email, :password, :role)";
        
        $stmt = $this->conn->prepare($query);

        // Sanitize and bind
        $user_name = explode('@', $data['email'])[0]; // Simple default username
        $role = 'customer';
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bindParam(":user_name", $user_name);
        $stmt->bindParam(":full_name", $data['name']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":role", $role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Get user details by email
     */
    public function getUserByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Verify user credentials and return user data
     */
    public function login($email, $password) {
        $userData = $this->getUserByEmail($email);
        
        if ($userData && password_verify($password, $userData['password'])) {
            // Remove password before returning
            unset($userData['password']);
            return $userData;
        }
        
        return false;
    }

    /**
     * Get user details by ID
     */
    public function getUserById($userId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update user's profile image
     */
    /**
     * Update user's profile image
     */
    public function updateProfileImage($userId, $imagePath) {
        $query = "UPDATE " . $this->table_name . " SET profile_image = :profile_image WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":profile_image", $imagePath);
        $stmt->bindParam(":user_id", $userId);
        return $stmt->execute();
    }

    /**
     * Update user's profile details
     */
    public function updateProfile($userId, $data) {
        $query = "UPDATE " . $this->table_name . " 
                  SET full_name = :full_name, contact = :contact 
                  WHERE user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":full_name", $data['full_name']);
        $stmt->bindParam(":contact", $data['contact']);
        $stmt->bindParam(":user_id", $userId);
        
        return $stmt->execute();
    }

    /**
     * Get the database connection
     */
    public function getConnection() {
        return $this->conn;
    }
}
