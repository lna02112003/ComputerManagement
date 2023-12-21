<?php
require_once("ConnectDB.php");

class RegisterController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function selectAllCategories() {
        $sql = "SELECT * FROM category WHERE row_delete = 0";
        $result = $this->conn->query($sql);

        $categories = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categories[] = $row;
            }
        }

        return $categories;
    }
    public function selectProductsByCategoryId($id) {
        $sql = "SELECT p.*, c.category_name 
                FROM product AS p
                JOIN product_category AS pc ON pc.product_id = p.product_id
                JOIN category AS c ON c.category_id = pc.category_id
                WHERE c.category_id = ? AND p.row_delete = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $products = [];
        
        while ($product = $result->fetch_assoc()) {
            $products[] = $product;
        }
    
        $stmt->close();
    
        return $products;
    }    
    
    public function addAccount($firstname, $middlename, $lastname, $username, $email, $address, $phone, $password, $image) {
        $sql = "INSERT INTO customer (firstname, middlename, lastname, username, email, address, phone, password, img, row_delete, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";
    
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            die('Error preparing statement: ' . $this->conn->error);
        }
    
        $stmt->bind_param("sssssssss", $firstname, $middlename, $lastname, $username, $email, $address, $phone, $password, $image);
    
        if (!$stmt->execute()) {
            die('Error executing statement: ' . $stmt->error);
        }
    
        $stmt->close();
    
        return true; // Assuming success
    }
    
}
?>
