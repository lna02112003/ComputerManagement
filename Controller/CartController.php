<?php

class CartController {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addToCart($productId, $quantity) {
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
    
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'quantity' => $quantity,
            ];
        }
        setcookie('cart', json_encode($cart), time() + (86400 * 30), "/");
    
        return true;
    }
    

    public function getCart() {
        return isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
    }

    public function deleteProduct($productId) {
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
        var_dump($cart);
    
        foreach ($cart as $key => $item) {
            if (isset($item['product_id']) && $item['product_id'] == $productId) {
                unset($cart[$key]);
                setcookie('cart', json_encode($cart), time() + (86400 * 30), "/");
                var_dump($cart);  // In ra giá trị mới của $cart sau khi xóa.
                return true;
            }
        }
    
        return false;
    }
    
    
}

?>
