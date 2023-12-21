<?php
    session_start();
    require_once("../Controller/CategoryController.php");
    require_once("../Controller/ProductController.php");
    require_once("..//Controller/ConnectDB.php");

    $categoryController = new CategoryController($conn);

    $productController = new ProductController($conn);

    $categories = $categoryController->selectAllCategories();

    $productsHot = $productController->selectProductHot();

    $products = $productController->selectAllProducts();

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
    <link href="/ComputerManagement/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/ComputerManagement/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/ComputerManagement/assets/css/templatemo-edu-meeting.css">
    <link rel="stylesheet" href="/ComputerManagement/assets/css/owl.css">
    <link rel="stylesheet" href="/ComputerManagement/assets/css/lightbox.css">
  </head>

<body>
  <header class="header-area header-sticky">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                      <a href="/View/index.php" class="logo">
                          Laptop e-commerce Website
                      </a>
                      <ul class="nav">
                          <li class=""><a href="index.php" class="active">Home</a></li>
                          <li class="has-sub">
                              <a href="javascript:void(0)">Category</a>
                              <ul class="sub-menu">
                                <?php
                                  foreach ($categories as $category) {
                                  ?>
                                      <li><a href="showProductByCategoryId.php?category_id=<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></a></li>
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
                                  <li class=""><a href="/ComputerManagement/Controller/ProcessLogout.php">Logout</a></li>
                                ';

                            } else {
                                echo '<li class=""><a href="login.php">Sign In</a></li>';
                            }
                          ?>
                      </ul>        
                  </nav>
              </div>
          </div>
      </div>
  </header>

  <section class="section main-banner" id="top" data-section="section1">
      <video autoplay muted loop id="bg-video">
          <source src="/ComputerManagement/assets/images/video_intro.mp4" type="video/mp4" />
      </video>

      <div class="video-overlay header-text">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="caption">
              <h6>WELCOME CUSTOMERS</h6>
              <h2>WELCOME TO E-COMMERCE WEBSITE</h2>
              <p>This is a place that provides the latest laptop models on the market and wants to bring the best experience to customers..</p>
              <div class="main-button-red">
                  <div class="scroll-to-section"><a href="#contact">Buy Now!</a></div>
              </div>
          </div>
              </div>
            </div>
          </div>
      </div>
  </section>

  <section class="services">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-service-item owl-carousel">
          
            <div class="item">
              <div class="icon">
                <img src="/ComputerManagement/assets/images/4236791.png" alt="">
              </div>
              <div class="down-content">
                <h4>Best Choice</h4>
                <p>We are proud to offer diversity with a wide range of laptops from leading brands in the market.</p>
              </div>
            </div>
            
            <div class="item">
              <div class="icon">
                <img src="/ComputerManagement/assets/images/2525347-200.png" alt="">
              </div>
              <div class="down-content">
                <h4>Best Experience</h4>
                <p>The user-friendly, easy-to-use interface makes it easy to search and compare products.</p>
              </div>
            </div>
            
            <div class="item">
              <div class="icon">
                <img src="/ComputerManagement/assets/images/pngegg.png" alt="">
              </div>
              <div class="down-content">
                <h4>Best Security</h4>
                <p>Personal and payment information is protected with top security measures.</p>
              </div>
            </div>
            
            <div class="item">
              <div class="icon">
                <img src="/ComputerManagement/assets/images/3194552-200.png" alt="">
              </div>
              <div class="down-content">
                <h4>Best Convenience</h4>
                <p>Fast and reliable delivery service to ensure you receive your products in the most convenient way.</p>
              </div>
            </div>
            
            <div class="item">
              <div class="icon">
                <img src="/ComputerManagement/assets/images/4236791.png" alt="">
              </div>
              <div class="down-content">
                <h4>Best Payment</h4>
                <p>Supports a variety of payment methods, including credit cards, bank transfers, e-wallets, and other popular online payment methods.</p>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="our-courses" id="meetings">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h2 class="text-center">Feture Products</h2>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="row">
            <?php
              foreach ($productsHot as $product) {
                  ?>
                  <div class="col-lg-4">
                      <div class="meeting-item">
                          <div class="thumb">
                              <a href="showProduct.php?product_id=<?php echo $product['product_id']; ?>"><img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['product_name']; ?>" height="350px"></a>
                          </div>
                          <div class="down-content">
                              <div class="date">
                                  <h6><?php echo $product['category_name']; ?></h6>
                              </div>
                              <a href="showProduct.php?product_id=<?php echo $product['product_id']; ?>"><h4><?php echo $product['product_name']; ?></h4></a><br>
                              <div class="price">
                                  <span><?php echo number_format($product['price_out'], 0, '', ','); ?>,000đ</span>
                              </div>
                          </div>
                      </div>
                  </div>
                  <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="our-courses" id="courses">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h2>Feedback</h2>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="owl-courses-item owl-carousel">
            <?php
              foreach ($products as $product) {
                ?>
                  <div class="item">
                    <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['product_name']; ?>" height="180px">
                    <div class="down-content">
                      <h4><?php echo $product['product_name'];  ?></h4>
                      <div class="info">
                        <div class="row">
                          <div class="col-6">
                            <ul>
                              <li><i class="fa fa-star"></i></li>
                              <li><i class="fa fa-star"></i></li>
                              <li><i class="fa fa-star"></i></li>
                              <li><i class="fa fa-star"></i></li>
                              <li><i class="fa fa-star"></i></li>
                            </ul>
                          </div>
                          <div class="col-6">
                            <span><?php echo number_format($product['price_out'], 0, '', ','); ?>,000đ</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="contact-us" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 align-self-center">
          <div class="row">
            <div class="col-lg-12">
              <form id="contact" action="" method="post">
                <div class="row">
                  <div class="col-lg-12">
                    <h2>We hope you will give us your feedback so we can develop further</h2>
                  </div>
                  <div class="col-lg-4">
                    <fieldset>
                      <input name="name" type="text" id="name" placeholder="YOURNAME...*" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-4">
                    <fieldset>
                    <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="YOUR EMAIL..." required="">
                  </fieldset>
                  </div>
                  <div class="col-lg-4">
                    <fieldset>
                      <input name="subject" type="text" id="subject" placeholder="SUBJECT...*" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <textarea name="message" type="text" class="form-control" id="message" placeholder="YOUR MESSAGE..." required=""></textarea>
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="button">SEND MESSAGE NOW</button>
                    </fieldset>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="right-info">
            <ul>
              <li>
                <h6>Phone Number</h6>
                <span>0969-325-914</span>
              </li>
              <li>
                <h6>Email Address</h6>
                <span>admin@gmail.com</span>
              </li>
              <li>
                <h6>Street Address</h6>
                <span>Cổ Nhuế, Bắc Từ Liêm, Hà Nội</span>
              </li>
              <li>
                <h6>Website URL</h6>
                <span>www.AEBBCompany.com</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="footer">
      <p>Copyright © 2023 AEBBCompany Co., Ltd. All Rights Reserved. 
          <br>Design: Project By AEBBCompany</p>
    </div>
  </section>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
    <script src="/ComputerManagement/vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="/ComputerManagement/assets/js/isotope.min.js"></script>
    <script src="/ComputerManagement/assets/js/owl-carousel.js"></script>
    <script src="/ComputerManagement/assets/js/lightbox.js"></script>
    <script src="/ComputerManagement/assets/js/tabs.js"></script>
    <script src="/ComputerManagement/assets/js/video.js"></script>
    <script src="/ComputerManagement/assets/js/slick-slider.js"></script>
    <script src="/ComputerManagement/assets/js/custom.js"></script>
    <script>
        $('.nav li:first').addClass('active');

        var showSection = function showSection(section, isAnimate) {
          var
          direction = section.replace(/#/, ''),
          reqSection = $('.section').filter('[data-section="' + direction + '"]'),
          reqSectionPos = reqSection.offset().top - 0;

          if (isAnimate) {
            $('body, html').animate({
              scrollTop: reqSectionPos },
            800);
          } else {
            $('body, html').scrollTop(reqSectionPos);
          }

        };

        var checkSection = function checkSection() {
          $('.section').each(function () {
            var
            $this = $(this),
            topEdge = $this.offset().top - 80,
            bottomEdge = topEdge + $this.height(),
            wScroll = $(window).scrollTop();
            if (topEdge < wScroll && bottomEdge > wScroll) {
              var
              currentId = $this.data('section'),
              reqLink = $('a').filter('[href*=\\#' + currentId + ']');
              reqLink.closest('li').addClass('active').
              siblings().removeClass('active');
            }
          });
        };

        $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function (e) {
          e.preventDefault();
          showSection($(this).attr('href'), true);
        });

        $(window).scroll(function () {
          checkSection();
        });
    </script>
</body>

</body>
</html>