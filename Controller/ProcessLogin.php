<?php
    require_once("LoginController.php");
    require_once("ConnectDB.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        var_dump($_POST);
        $email = $_POST["email"];
        $password = $_POST["password"];
    
        $loginController = new LoginController($conn);

        $result = $loginController->login($email, $password);

        if ($result == "customer") {
            header("Location: ../View/index.php");
            exit();
        } else if ($result == "admin")  {
            header("Location: ../View/admin/index.php");
            exit();
        } else if ($result == "false") {
            header("Location: ../View/login.php?error=invalid_credentials");
            exit();
        }
    }
?>
