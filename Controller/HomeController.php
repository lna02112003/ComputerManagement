<?php
require_once("ConnectDB.php");

class HomeController
{
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function searchProductByCategoryId()
    {
        if (isset($_GET['query'])) {

        } else {
        }
    }
}
