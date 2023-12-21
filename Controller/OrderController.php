<?php
require_once("ConnectDB.php");
require_once("ProductController.php");
require_once("UserController.php");

class OrderController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function SelectAllOrders() {
        $sql = "SELECT * FROM `order` WHERE row_delete = 0";
        $stmt = $this->conn->prepare($sql);
    
        if (!$stmt) {
            die('Error in preparing statement: ' . $this->conn->error);
        }
    
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        $orders = [];
    
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    
        return $orders;
    }

    public function updateOrder($order_id, $total_order, $status, $description) {
        if ($description === 'Thanh toán bằng tiền mặt' && $status === 'Thanh toán thành công') {
            $this->MoneyPay($order_id);
        } else if ($description === 'Thanh toán bằng VNpay'&& $status === 'Thanh toán thành công') {
            $this->VNPaySuccess($order_id);
        }
        $sql = "UPDATE `order` SET total_order = ?, status = ?, description = ? WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt === false) {
            die('Error in preparing UPDATE statement: ' . $this->conn->error);
        }
    
        $stmt->bind_param('dssi', $total_order, $status, $description, $order_id);
        
        $result = $stmt->execute();
    
        if ($result === false) {
            die('Error in executing UPDATE statement: ' . $stmt->error);
        }
        $stmt->close();
        return $result;
 
    }

    public function deleteOrder($order_id) {
        if (!is_numeric($order_id) || $order_id <= 0) {
            return false;
        }
    
        $order_id = intval($order_id);
    
        $sql = "UPDATE `order` SET row_delete = 1 WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt === false) {
            die('Error in preparing DELETE statement: ' . $this->conn->error);
        }
    
        $stmt->bind_param("i", $order_id);
    
        $result = $stmt->execute();
    
        if ($result === false) {
            die('Error in executing DELETE statement: ' . $stmt->error);
        }
    
        $stmt->close();
    
        return $result;
    }
    

    public function selectOrderById($order_id) {
        $sql = "SELECT * FROM `order` WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $order = (object) $result->fetch_assoc();  // Cast to object
    
        return $order;
    }
    
    public function getAllOrderByOrderId($id) {
        $status = "Đang chờ thanh toán";
        $sql = "SELECT od.*,p.product_name, p.image_url FROM order_detail as od
                JOIN product as p ON p.product_id = od.product_id
                JOIN `order` as o ON o.order_id = od.order_id
                WHERE o.order_id = ? AND od.row_delete = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    
        return $orders;
    }
    public function getAllOrders() {
        $status = "Đang chờ thanh toán";
        $sql = "SELECT * FROM order_detail as od
                JOIN `order` as o ON o.order_id = od.order_id
                WHERE o.status = ? AND od.row_delete = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $status);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    
        return $orders;
    }
      

    public function SaveOrder(){
        if (isset($_COOKIE['cart'])) {
            $cartItems = json_decode($_COOKIE['cart'], true);
            $totalOrder = 0;

            foreach ($cartItems as $cartItem) {
                $productController = new ProductController($this->conn);
                $productId = $cartItem['product_id'];
                $quantity = $cartItem['quantity'];
                $product = $productController->getProductById($productId);
                $totalOrder += $quantity * $product['price_out'];
            }
        
            if (isset($_SESSION['customer'])) {
                $userId = $_SESSION['customer']['id'];
                $description = "";
                $status = "Đang chờ thanh toán";
        
                $sqlOrder = "INSERT INTO `order` (customer_id, description, total_order, status, row_delete, created_at, updated_at) VALUES (?, ?, ?, ?, 0, NOW(), NOW())";
                $stmtOrder = $this->conn->prepare($sqlOrder);
                if ($stmtOrder === false) {
                    return die('Error in preparing ORDER statement: ' . $this->conn->error);
                }
        
                $stmtOrder->bind_param("isds", $userId, $description, $totalOrder, $status);
        
                $resultOrder = $stmtOrder->execute();
                if ($resultOrder === false) {
                    return die('Error in executing ORDER statement: ' . $stmtOrder->error);
                }
        
                $order_id = $this->conn->insert_id;
        
                foreach ($cartItems as $cartItem) {
                    $productController = new ProductController($this->conn);
                    $productId = $cartItem['product_id'];
                    $quantity = $cartItem['quantity'];
                    $product = $productController->getProductById($productId);
                    $productDetails ="RAM: " . $product['ram'] . ", Display Size: " . $product['display_size'] . ", Storage: " . $product['storage'];
                
                    $sqlDetail = 'INSERT INTO order_detail (order_id, product_id, quantity, unit_price, description, created_at, updated_at, row_delete) VALUES (?, ?, ?, ?, ?, NOW(), NOW(), 0)';
                    $stmtDetail = $this->conn->prepare($sqlDetail);
                    if ($stmtDetail === false) {
                        return die('Error in preparing DETAIL statement: ' . $this->conn->error);
                    }
                
                    $stmtDetail->bind_param('iiids', $order_id, $productId, $quantity, $product['price_out'], $productDetails);
                
                    $resultDetail = $stmtDetail->execute();
                    if ($resultDetail === false) {
                        return die('Error in executing DETAIL statement: ' . $stmtDetail->error);
                    }
                }                
                setcookie('cart', '', time() - 3600, '/');
            }
        }
    }
    public function MoneyPay($order_id) {
        $description = "Thanh toán bằng tiền mặt";
        
        $sql = 'UPDATE `order` SET description = ? WHERE order_id = ?';
        
        $sql_select = 'SELECT product_id, quantity FROM order_detail WHERE order_id = ?';
        $stmt_select = $this->conn->prepare($sql_select);
        $stmt_select->bind_param('i', $order_id);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();

        while ($row = $result_select->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
    
            $sql_update_product = 'UPDATE product SET quantity = quantity - ? WHERE product_id = ?';
            $stmt_update_product = $this->conn->prepare($sql_update_product);
            $stmt_update_product->bind_param('ii', $quantity, $product_id);
            $result_update_product = $stmt_update_product->execute();
    
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $description, $order_id);
        $result = $stmt->execute();
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function VNPaySuccess($order_id) {
        $status = "Thanh toán thành công";
        
        $sql_select = 'SELECT product_id, quantity FROM order_detail WHERE order_id = ?';
        $stmt_select = $this->conn->prepare($sql_select);
        $stmt_select->bind_param('i', $order_id);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();
    
        $sql_update_order = 'UPDATE `order` SET status = ? WHERE order_id = ?';
        $stmt_update_order = $this->conn->prepare($sql_update_order);
        $stmt_update_order->bind_param('si', $status, $order_id);
        $result_update_order = $stmt_update_order->execute();
    
        if (!$result_update_order) {
            return false;
        }
    
        while ($row = $result_select->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
    
            $sql_update_product = 'UPDATE product SET quantity = quantity - ? WHERE product_id = ?';
            $stmt_update_product = $this->conn->prepare($sql_update_product);
            $stmt_update_product->bind_param('ii', $quantity, $product_id);
            $result_update_product = $stmt_update_product->execute();
    
        }
    
        return true;
    }    
    public function getOrder($order_id) {
        $sql = 'SELECT * FROM `order` WHERE `order`.order_id = ?';
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt === false) {
            die('Error in preparing statement: ' . $this->conn->error);
        }
    
        $stmt->bind_param('i', $order_id);
    
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        $order = $result->fetch_assoc();
    
        $stmt->close();
    
        return $order;
    }
    
    
    public function VNPay($order_id) { 
        $description = "Thanh toán bằng VNpay";
        
        $sql = 'UPDATE `order` SET description = ? WHERE order_id = ?';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $description, $order_id);
        $stmt->execute();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order = $this->getOrder($order_id);
        $userController = new UserController($this->conn);
        $customer = $userController->getCustomerByID($order['customer_id']);
        $vnp_TmnCode = '96PV39NC';
        $vnp_HashSecret = 'ZYCTQITJBJSIYKRGUROFFNJHNQGCRSPZ';
        $vnp_ReturnUrl = 'http://localhost/ComputerManagement/View/vnpay_return.php';
        $vnp_TestUrl = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $expire = date('YmdHis', strtotime('+1 hour'));
        $orderAmount =(int)$order['total_order'];  
        $inputData = [
            "vnp_Version" => "2.1.0",
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_Amount' => $orderAmount*100000,
            'vnp_Command' => "pay",
            'vnp_CreateDate' => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_ExpireDate"=>$expire,
            'vnp_IpAddr' => '192.168.12.1',
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => 'Payment for Order #' . $order_id,
            "vnp_OrderType" => "other",
            'vnp_ReturnUrl' => $vnp_ReturnUrl,
            'vnp_TxnRef' => $order_id,
            "vnp_Bill_Mobile"=>$customer->phone,
            "vnp_Bill_Email"=>$customer->email,
            "vnp_Bill_FirstName"=>$customer->firstname,
            "vnp_Bill_LastName"=>$customer->middlename.' '.$customer->lastname,
            "vnp_Bill_Address"=>$customer->address,
            "vnp_Bill_City"=>$customer->address,
            "vnp_Bill_Country"=>"Viet Nam",
            "vnp_Inv_Phone"=>"0969325914",
            "vnp_Inv_Email"=>"namanhle02112003@gmail.com",
            "vnp_Inv_Customer"=>"Lê Nam Anh",
            "vnp_Inv_Address"=>"Cổ Nhuế, Bắc Từ Liêm, Hà Nội",
            "vnp_Inv_Company"=>"NahinnStore",
            "vnp_Inv_Taxcode"=>"02112003",
            "vnp_Inv_Type"=>"BillPayment"
        ];
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_TestUrl . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return ($vnp_Url);
    }
}
?>
