<?php
require_once("ConnectDB.php");

class UserController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }  

    public function getUserByID($id) {
        $sql = "SELECT * FROM user WHERE user_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    
        $result = $stmt->get_result()->fetch_object();
    
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function getCustomerByID($id) {
        $sql = "SELECT * FROM customer WHERE customer_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    
        $result = $stmt->get_result()->fetch_object();
    
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }
    
    public function selectAllCustomer() {
        $sql = "SELECT * FROM customer WHERE row_delete = 0";
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt === false) {
            die('Error in preparing SELECT statement: ' . $this->conn->error);
        }
    
        $stmt->execute();
    
        if ($stmt->error) {
            die('Error in executing SELECT statement: ' . $stmt->error);
        }
    
        $result = $stmt->get_result();
    
        $customers = [];
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    
        $stmt->close();
    
        return $customers;
    }
    public function updateCustomer($customer_id, $firstname, $middlename, $lastname, $username, $email, $address, $phone, $img) {
        $sql = "UPDATE customer SET firstname = ?, middlename = ?, lastname = ?, username = ?, email = ?, address = ?, phone = ?, img = ? WHERE customer_id = ?";
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt === false) {
            die('Error in preparing UPDATE statement: ' . $this->conn->error);
        }
    
        $stmt->bind_param("ssssssssi", $firstname, $middlename, $lastname, $username, $email, $address, $phone, $img, $customer_id);
    
        $result = $stmt->execute();
    
        if ($result === false) {
            die('Error in executing UPDATE statement: ' . $stmt->error);
        }
    
        $stmt->close();
    
        return $result;
    }
    
    public function deleteCustomer($customer_id) {
        if (!is_numeric($customer_id) || $customer_id <= 0) {
            return false;
        }

        $customer_id = intval($customer_id);

        $sql = "UPDATE customer SET row_delete = 1 WHERE customer_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $customer_id);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }
    
}
?>
