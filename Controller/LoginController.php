<?php
require_once("ConnectDB.php");

class LoginController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($email, $password) {
        session_start();
        $sql = "SELECT * FROM customer WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
    
        $stmt->bind_param("s", $email);
    
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        $customer = $result->fetch_assoc();
    
        if ($customer && password_verify($password, $customer['password'])) {
            $_SESSION['customer'] = array(
                'type' => 'customer',
                'id' => $customer['customer_id']
            );            
            return "customer";
        } else {
            $sql = "SELECT * FROM user WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
    
            $stmt->bind_param("s", $email);
    
            $stmt->execute();
    
            $result = $stmt->get_result();
    
            $user = $result->fetch_assoc();
    
            if ($user && password_verify($password, $user['password'])) {
                if ($user['role'] == 1) {
                    $_SESSION['manage'] = array(
                        'type' => 'manage',
                        'id' => $user['user_id']
                    ); 
                    return "manage";
                } elseif ($user['role'] == 2) {
                    $_SESSION['admin'] = array(
                        'type' => 'admin',
                        'id' => $user['user_id']
                    ); 
                    return "admin";
                }
                $_SESSION['user_id'] = $user['user_id'];
            }
        }

        return "false";
    }    
    public function closeConnection() {
        $this->conn->close();
    }
}
?>
