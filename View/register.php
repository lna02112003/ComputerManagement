<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Register</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
        <meta content="Coderthemes" name="author">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Bootstrap select pluings -->
        <link href="../assets\libs\bootstrap-select\bootstrap-select.min.css" rel="stylesheet" type="text/css">

        <!-- App css -->
        <link href="../assets\css\bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet">
        <link href="../assets\css\icons.min.css" rel="stylesheet" type="text/css">
        <link href="../assets\css\app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet">
        <link href="../assets\css\login.css" rel="stylesheet">

    </head>

    <body class="authentication-bg">
        <div class="home-btn d-none d-sm-block">
            <a href="index.html"><i class="fas fa-home h2"></i></a>
        </div>
        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div>

                            <div class="text-center authentication-logo mb-4">
                                <a href="index.php" class="logo-dark">
                                    <span>AEBB</span> Company
                                </a>
                            </div>

                            <form action="../Controller/ProcessRegister.php" id="form" method="POST" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="firstname">First Name</label>
                                    <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Enter your fist name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="middlename">Middle Name</label>
                                    <input class="form-control" type="text" name="middlename" id="middlename" placeholder="Enter your middle name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="lastname">Last Name</label>
                                    <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Enter your last name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="username">UserName</label>
                                    <input class="form-control" type="text" name="username" id="username" placeholder="Enter your username" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email address</label>
                                    <input class="form-control" type="email" name="email" id="email" required placeholder="Enter your email">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address">Address</label>
                                    <input class="form-control" type="text" name="address" id="address" required placeholder="Enter your address">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone">Phone</label>
                                    <input class="form-control" type="number" name="phone" id="phone" required placeholder="Enter your phone">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password" required id="password" placeholder="Enter your password">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="repassword">Retype Password</label>
                                    <input class="form-control" type="password" name="repassword" required id="password" placeholder="Enter your retype password">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="image">Image</label>
                                    <input class="form-control" type="file" name="image" id="image" required>
                                </div>
                                <div class="form-group mb-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signup">
                                        <label class="custom-control-label" for="checkbox-signup">I accept <a href="javascript: void(0);" class="text-primary">Terms and Conditions</a></label>
                                    </div>
                                </div>

                                <div class="form-group mb-3 text-center">
                                    <button class="btn btn-primary btn-lg width-lg btn-rounded" type="submit"> Sign Up</button>
                                </div>
                            </form> 

                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <p class="text-muted">Already have an account?  <a href="login.php" class="text-dark ml-1">Sign In</a></p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    


        <script src="../assets\js\vendor.min.js"></script>

        <script src="../assets\libs\bootstrap-select\bootstrap-select.min.js"></script>

        <script src="../assets\js\app.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var form = document.getElementById('form');

                form.addEventListener('submit', function (event) {
                    var firstname = document.getElementById('firstname').value;
                    var middlename = document.getElementById('middlename').value;
                    var lastname = document.getElementById('lastname').value;
                    var username = document.getElementById('username').value;
                    var email = document.getElementById('email').value;
                    var address = document.getElementById('address').value;
                    var phone = document.getElementById('phone').value;
                    var password = document.getElementById('password').value;
                    var repassword = document.getElementById('repassword').value;
                    var image = document.getElementById('image').value;

                    if (!firstname || !middlename || !lastname || !username || !email || !address || !phone || !password || !repassword || !image) {
                        alert('Please fill in all fields.');
                        event.preventDefault();
                    }

                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        alert('Please enter a valid email address.');
                        event.preventDefault();
                    }

                    if (phone.length !== 10 || !/^\d+$/.test(phone)) {
                        alert('Please enter a valid 10-digit phone number.');
                        event.preventDefault();
                    }

                    if (password !== repassword) {
                        alert('Passwords do not match.');
                        event.preventDefault();
                    }

                });
            });
        </script>
        
    </body>
</html>