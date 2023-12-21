<?php
require_once("ConnectDB.php");

class ProductController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function selectAllProducts() {
        $sql = "SELECT p.*, c.category_name 
                FROM product as p 
                JOIN product_category as pc on pc.product_id = p.product_id
                JOIN category as c on c.category_id = pc.category_id
                WHERE p.row_delete = 0";
        $result = $this->conn->query($sql);

        $products = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }

        return $products;
    }
    public function selectProductHot(){
        $sql = "SELECT p.*, c.category_name 
                FROM product as p 
                JOIN product_category as pc on pc.product_id = p.product_id
                JOIN category as c on c.category_id = pc.category_id
                WHERE p.row_delete = 0 AND p.hot = 1";
        $result = $this->conn->query($sql);

        $productHot = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productHot[] = $row;
            }
        }
        return $productHot;
    }
    public function selectProductById($productId) {
        $sql = "SELECT p.*, c.category_name 
                FROM product as p 
                JOIN product_category as pc on pc.product_id = p.product_id
                JOIN category as c on c.category_id = pc.category_id
                WHERE p.product_id = ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
    
        return $product;
    }
    
    public function addProduct($category_id, $product_name, $price_in, $price_out, $ram, $storage, $quantity, $display_size,$uploadPath, $description) {
        $this->conn->begin_transaction();
    
        try {
            $productSql = "INSERT INTO product (product_name, price_in, price_out, ram, hot, storage, quantity, display_size, description, image_url, row_delete, created_at, updated_at) VALUES (?, ?, ?, ?, 0, ?, ?, ?, ?, ?, 0, NOW(), NOW())";
            $productStmt = $this->conn->prepare($productSql);
            $productStmt->bind_param("sddssisss", $product_name, $price_in, $price_out, $ram, $storage, $quantity, $display_size, $uploadPath, $description);
            $productResult = $productStmt->execute();
    
            $productId = $productStmt->insert_id;
    
            $productStmt->close();
    
            if ($productResult) {
                $productCategorySql = "INSERT INTO product_category (product_id, category_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
                $productCategoryStmt = $this->conn->prepare($productCategorySql);
                $productCategoryStmt->bind_param("ii", $productId, $category_id);
                $productCategoryResult = $productCategoryStmt->execute();
    
                $productCategoryStmt->close();
    
                if ($productCategoryResult) {
                    $this->conn->commit();
                    return true;
                } else {
                    $this->conn->rollback();
                    return false;
                }
            } else {
                $this->conn->rollback();
                return false;
            }
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function updateProduct($productId, $category_id, $product_name, $price_in, $price_out, $ram, $storage, $quantity, $display_size, $description, $hot, $image_url) {
        $this->conn->begin_transaction();
        $hotInt = (int)$hot;
        try {
            $productSql = "UPDATE product SET 
                product_name = ?, 
                price_in = ?, 
                price_out = ?, 
                ram = ?, 
                storage = ?, 
                quantity = ?, 
                display_size = ?, 
                description = ?, 
                image_url = ?, 
                hot = ?,
                updated_at = NOW() 
                WHERE product_id = ?";
        
            $productStmt = $this->conn->prepare($productSql);
        
            $productStmt->bind_param("sddssisssii", $product_name, $price_in, $price_out, $ram, $storage, $quantity, $display_size, $description, $image_url, $hotInt, $productId);
        
            $productResult = $productStmt->execute();
            $productStmt->close();
        
            if ($productResult) {
                $deleteLinksSql = "DELETE FROM product_category WHERE product_id = ?";
                $deleteLinksStmt = $this->conn->prepare($deleteLinksSql);
                $deleteLinksStmt->bind_param("i", $productId);
                $deleteLinksResult = $deleteLinksStmt->execute();
                $deleteLinksStmt->close();
        
                if ($deleteLinksResult) {
                    $productCategorySql = "INSERT INTO product_category (product_id, category_id, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
                    $productCategoryStmt = $this->conn->prepare($productCategorySql);
                    $productCategoryStmt->bind_param("ii", $productId, $category_id);
                    $productCategoryResult = $productCategoryStmt->execute();
                    $productCategoryStmt->close();
        
                    if ($productCategoryResult) {
                        $this->conn->commit();
                        return true;
                    } else {
                        $this->conn->rollback();
                        return false;
                    }
                } else {
                    $this->conn->rollback();
                    return false;
                }
            } else {
                $this->conn->rollback();
                return false;
            }
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }        
    }
       
    public function deleteProduct($productId) {
        if (!is_numeric($productId) || $productId <= 0) {
            return false;
        }

        $productId = intval($productId);

        $sql = "UPDATE product SET row_delete = 1 WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $productId);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }
    public function getProductById($productId) {
        $sql = "SELECT p.*, c.category_name
                FROM product as p
                INNER JOIN product_category as pc ON p.product_id = pc.product_id
                INNER JOIN category as c ON pc.category_id = c.category_id
                WHERE p.product_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            die('Error in SQL query: ' . $this->conn->error);
        }
        
        $stmt->bind_param("i", $productId);
        
        $result = $stmt->execute();
        
        if (!$result) {
            die('Error executing query: ' . $stmt->error);
        }
    
        $data = $stmt->get_result()->fetch_assoc();
    
        $stmt->close();
        
        return $data;
    }    
    
    public function searchProductByCategoryId($categoryId, $query)
    {
        $sql = "SELECT *, category.category_name
            FROM product 
            INNER JOIN product_category ON product.product_id = product_category.product_id 
            INNER JOIN category ON product_category.category_id = category.category_id
            WHERE product_category.category_id = ? 
            AND LOWER(product.product_name) LIKE LOWER(?)
            ";

        $stmt = $this->conn->prepare($sql);
        $categoryId = intval($categoryId);
        $query = "%" . $this->conn->real_escape_string($query) . "%";

        $stmt->bind_param("is", $categoryId, $query);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }
}
?>
