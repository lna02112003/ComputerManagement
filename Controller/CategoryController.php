<?php
require_once("ConnectDB.php");

class CategoryController {
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
    public function selectCategoryById($categoryId) {
        $sql = "SELECT * FROM category WHERE category_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();
        $stmt->close();
    
        return $category;
    }
    
    public function addCategory($categoryName, $description) {
        $sql = "INSERT INTO category (category_name, description, row_delete, created_at, updated_at) VALUES (?, ?, 0, NOW(), NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $categoryName, $description);
    
        $result = $stmt->execute();
    
        $stmt->close();
    
        return $result;
    }

    public function updateCategory($categoryId, $categoryName, $description) {
        $sql = "UPDATE category SET category_name = ?, description = ? WHERE category_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $categoryName, $description, $categoryId);
    
        $result = $stmt->execute();
    
        $stmt->close();
    
        return $result;
    }
    public function deleteCategory($categoryId) {
        if (!is_numeric($categoryId) || $categoryId <= 0) {
            return false;
        }

        $categoryId = intval($categoryId);

        $sql = "UPDATE category SET row_delete = 1 WHERE category_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $categoryId);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }
}
?>
