<?php
    require_once("RegisterController.php");
    require_once("ConnectDB.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = $_POST["firstname"];
        $middlename = $_POST["middlename"];
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];
        $password = $_POST["password"];
        $image = $_FILES["image"];
    
        if ($image["error"] == UPLOAD_ERR_OK) {
            $uploadDir = "../Storage/Profile/";
            $uploadPath = $uploadDir . basename($image["name"]);
    
            move_uploaded_file($image["tmp_name"], $uploadPath);
    
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
            $registerController = new RegisterController($conn);
    
            $result = $registerController->addAccount($firstname, $middlename, $lastname, $username, $email, $address, $phone, $hashedPassword, $uploadPath);
    
            if ($result) {
                header("Location: ../View/login.php");
                exit();
            } else {
                header("Location: ../View/register.php");
                exit();
            }
        }
    }    
?>
