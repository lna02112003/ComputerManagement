<?php
    session_start();
    require_once("../../Controller/CartController.php");
    require_once("../../Controller/CategoryController.php");
    require_once("../../Controller/ProductController.php");
    require_once("../../Controller/ConnectDB.php");

    $categoryController = new CategoryController($conn);

    $productController = new ProductController($conn);

    $cartController = new CartController($conn);

    $categories = $categoryController->selectAllCategories();

    $cart = $cartController->getCart();

    if (isset($_SESSION['customer'])) {
        $userType = $_SESSION['customer']['type'];
        $userId = $_SESSION['customer']['id'];
        if ($userType == 'customer') {
            $isLoggedIn = true;
        } 
    } else {
        $isLoggedIn = false;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>Laptop e-commerce Website</title>
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../../assets/css/templatemo-edu-meeting.css">
    <link rel="stylesheet" href="../../assets/css/owl.css">
    <link rel="stylesheet" href="../../assets/css/lightbox.css">
    <link rel="stylesheet" href="../../assets/css/cart.css">
</head>

<body>
    <header class="header-area header-sticky">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                      <a href="index.php" class="logo">
                          Laptop e-commerce Website
                      </a>
                      <ul class="nav">
                          <li class=""><a href="/ComputerManagement/View/index.php" class="active">Home</a></li>
                          <li class="has-sub">
                              <a href="javascript:void(0)">Category</a>
                              <ul class="sub-menu">
                                <?php
                                  foreach ($categories as $category) {
                                  ?>
                                      <li><a href="/ComputerManagement/View/showProductByCategoryId.php?category_id=<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></a></li>
                                  <?php
                                  }
                                ?>
                            </ul>
                          </li>
                          <li class=""><a href="#contact">Contact Us</a></li> 
                          <?php
                            if ($isLoggedIn) {
                              
                                echo '
                                  <li><a href="/ComputerManagement/View/customer/Cart.php">Cart</a></li>
                                  <li class=""><a href="../../Controller/ProcessLogout.php">Logout</a></li>
                                ';

                            } else {
                                echo '<li class=""><a href="/ComputerManagement/View/login.php">Sign In</a></li>';
                            }
                          ?>
                      </ul>        
                  </nav>
              </div>
          </div>
      </div>
  </header>

    <section class="our-courses" id="courses">
        <div class="container">
            <div class="data">
                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Ram</th>
                            <th>Storage</th>
                            <th>Quantity</th>
                            <th>Display Size</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        foreach ($cart as $key => $cartItem) {
                            if (is_array($cartItem) && isset($cartItem['product_id']) && isset($cartItem['quantity'])) {
                                $productId = $cartItem['product_id'];
                                $quantity = $cartItem['quantity'];
                                $product = $productController->getProductById($productId);

                                if ($product) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $product['product_name']; ?></td>
                                        <td><img src="../<?php echo $product['image_url']; ?>" alt="<?php echo $product['product_name']; ?>" class="img-product"></td>
                                        <td id="price_<?php echo $productId; ?>"><?php echo number_format($product['price_out'], 0, '', ','); ?>,000đ</td>
                                        <td><?php echo $product['ram']; ?></td>
                                        <td><?php echo $product['storage']; ?></td>
                                        <td class="quantity-cell">
                                            <form action="" method="POST" class="form_quantity" id="quantityForm_<?php echo $productId; ?>">
                                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                <input type="hidden" name="quantity" value="<?php echo $quantity; ?>" class="input_quantity" id="quantityInput_<?php echo $productId; ?>">
                                                <button type="button" name="btn_decending" class="btn_decending" onclick="changeQuantity(<?php echo $productId; ?>, -1)">-</button>
                                                <input type="text" name="quantity_display" value="<?php echo $quantity; ?>" class="input_quantity" id="quantityDisplay_<?php echo $productId; ?>" readonly onchange="updateCart($productId,$quantity)">
                                                <button type="button" name="btn_acending" class="btn_acending" onclick="changeQuantity(<?php echo $productId; ?>, 1)">+</button>
                                            </form>
                                        </td>
                                        <td><?php echo $product['display_size']; ?></td>
                                        <td class="total" id="total_<?php echo $productId; ?>"><?php echo number_format($product['price_out'] * $quantity, 0, '', ','); ?>,000đ</td>
                                        <td><a href="../../Controller/DeleteProductCart.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-danger">Delete</a></td>
                                    </tr>
                                    <?php
                                    $i++;
                                } else {
                                    echo "Product not found for ID: $productId";
                                }
                            } else {
                                echo "Invalid data in cart!";
                            }
                        }
                        ?>
                    <tr>
                        <td colspan="8">Total Cart:</td>
                        <td class="total-cart" colspan="2">0</td>
                    </tr>
                    <tr>
                        <td colspan="10" class="col-pay"><a class="btn btn-primary btn-pay" href="../../Controller/ProcessOrder.php">Pay Now</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../../assets/js/isotope.min.js"></script>
    <script src="../../assets/js/owl-carousel.js"></script>
    <script src="../../assets/js/lightbox.js"></script>
    <script src="../../assets/js/tabs.js"></script>
    <script src="../../assets/js/video.js"></script>
    <script src="../../assets/js/slick-slider.js"></script>
    <script src="../../assets/js/custom.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', updateTotalCart);
        function changeQuantity(productId, amount) {
            var quantityInput = document.getElementById('quantityInput_' + productId);
            var quantityDisplay = document.getElementById('quantityDisplay_' + productId);
            var currentQuantity = parseInt(quantityInput.value);

            if (currentQuantity + amount > 0) {
                quantityInput.value = currentQuantity + amount;
                quantityDisplay.value = currentQuantity + amount;
                updateTotal(productId);
                updateCart(productId,quantityInput.value);
            }
        }

        function updateTotal(productId) {
            var priceElement = document.getElementById('price_' + productId);
            var quantityElement = document.getElementById('quantityInput_' + productId);
            var totalElement = document.getElementById('total_' + productId);

            if (priceElement && quantityElement && totalElement) {
                var price = parseFloat(priceElement.innerText.replace(/[^0-9.-]+/g, ""));
                var quantity = parseInt(quantityElement.value);
                var total = price * quantity;
                totalElement.innerText = number_format(total, 0, '', ',') + 'đ';
            }
            updateTotalCart();
        }

        document.addEventListener('DOMContentLoaded', function () {
            <?php
            foreach ($cart as $cartItem) {
                if (is_array($cartItem) && isset($cartItem['product_id']) && isset($cartItem['quantity'])) {
                    $productId = $cartItem['product_id'];
                    echo "document.getElementById('quantityInput_$productId').addEventListener('input', function () {
                            updateTotal($productId);
                            updateTotalCart();
                        });";
                }
            }
            ?>
        });

        function number_format(number, decimals, dec_point, thousands_sep) {
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
        function updateTotalCart() {
            var totalElements = document.querySelectorAll('.total');
            var totalCartElement = document.querySelector('.total-cart');

            var totalCart = 0;

            totalElements.forEach(function (element) {
                var totalValue = parseFloat(element.innerHTML.replace(/[^0-9.-]+/g, ''));
                totalCart += totalValue;
            });

            totalCartElement.innerHTML = number_format(totalCart, 0, '', ',') + 'đ';
        }
        document.addEventListener('DOMContentLoaded', function () {
            <?php
            foreach ($cart as $cartItem) {
                if (is_array($cartItem) && isset($cartItem['product_id']) && isset($cartItem['quantity'])) {
                    $productId = $cartItem['product_id'];
                    echo "document.getElementById('quantityInput_$productId').addEventListener('input', function () {
                            updateCart($productId, this.value);
                        });";
                }
            }
            ?>
        });

        function updateCart(productId, quantity) {
            quantity = parseInt(quantity);
            var formData = { productId: productId, quantity: quantity };

            fetch('../../Controller/UpdateCart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                console.log('Cart updated:', data);
            })
            .catch(function (error) {
                console.error('Error updating cart:', error);
            });
        }
    </script>
</body>

</html>
