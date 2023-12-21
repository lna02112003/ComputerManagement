<?php
require_once("UserController.php");
require_once("ConnectDB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customer_id = $_POST['customer_id'];

    $customerController = new UserController($conn);

    $existingAccount = $customerController->getCustomerByID($customer_id);

    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $image = $_FILES["image"];
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = "../Storage/Profile/";
        $image_url = $uploadDir . basename($image["name"]);

        move_uploaded_file($image["tmp_name"], $image_url);
    } else {
        $image_url = $existingAccount->img;
    }
    $success = $customerController->updateCustomer($customer_id, $firstname, $middlename, $lastname, $username, $email, $address, $phone, $image_url);

    if ($success) {
        header("Location: ../View/admin/AccountCustomer.php");
        exit();
    } else {
        echo "Error updating product.";
    }
} else {
    header("Location: ../View/admin/editCustomer.php");
    exit();
}
?>
