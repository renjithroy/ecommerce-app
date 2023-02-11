<?php
session_start();
include('server/connection.php');

if(isset($_POST['search'])){
//return searched products

//1.Determine Page no

  if(isset($_GET['page_no']) && $_GET['page_no'] != "")
  {
    //if user has already entered the page, then page no is the one that they selected
    $page_no = $_GET['page_no'];
  }
  else
  {
    //if user just entered the page, then default page no is 1.
    $page_no = 1;
  }

  $category = $_POST['category'];
  $price = $_POST['price'];

//2.return no.of products

  //count of product that match the category and price
  $stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM products WHERE prod_category=? AND product_price<=? "); //returns total no.of products in database

  $stmt1->bind_param("ii",$category,$price);

  $stmt1->execute(); //executes the sql query

  $stmt1->bind_result($total_records); //stores result into a variable as array (its an array of result)

  $stmt1->store_result();

  $stmt1->fetch();

//3. set total no.of products per page

  $total_records_per_page =8;
  
  $offset = ($page_no-1) * $total_records_per_page;

  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  $adjacents = "2";

  $total_no_of_pages = ceil($total_records/$total_records_per_page); 

//4. Get all products

  $stmt2 = $conn->prepare("SELECT * FROM products WHERE prod_category=? AND product_price<=? LIMIT $offset,$total_records_per_page");
  $stmt2->bind_param("ii",$category,$price);
  $stmt2->execute();

  $products = $stmt2->get_result();

}
else //return all products
{
//1.Determine Page no

  if(isset($_GET['page_no']) && $_GET['page_no'] != "")
  {
    //if user has already entered the page, then page_ no is the one that they selected
    $page_no = $_GET['page_no'];
  }
  else
  {
    //if user just entered the page, then default page no is 1.
    $page_no = 1;
  }

//2.return no.of products

  $stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM products"); //returns total no.of products in database

  $stmt1->execute(); //executes the sql query

  $stmt1->bind_result($total_records); //stores result into a variable as array (its an array of result)

  $stmt1->store_result();

  $stmt1->fetch();

//3. set total no.of products per page

  $total_records_per_page = 8;
  
  $offset = ($page_no-1) * $total_records_per_page;

  $previous_page = $page_no - 1;
  $next_page = $page_no + 1;

  $adjacents = "2";

  $total_no_of_pages = ceil($total_records/$total_records_per_page); //ex- 12/8 = 1.5 which is ceiled so 2 pages of products

//4. Get all products

  $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset,$total_records_per_page");

  $stmt2->execute();

  $products = $stmt2->get_result();


}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
    integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
  <link rel="stylesheet" href="assets/css/style.css" />

  <style>
    /* .product img{
            width: 100%;
            height: auto;
            box-sizing: border-box;
            object-fit: cover;
        } */

    .pagination a {
      color: coral;
    }

    .pagination a:hover {
      color: #fff;
      background-color: coral;
    }

    input[type='range']::-webkit-slider-thumb {
        -webkit-appearance: none !important;
        -webkit-border-radius: 2px;
        background-color: #fb774b;
        height: 21px;
        width: 9px;
    }

  input[type="radio"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
  }

  input[type='radio']:checked{
    background-color: #fb774b;
    border: none;
  }

        

  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
    <div class="container">
      <a href="index.php"><img src="assets/imgs/weaved-logo.png" class="nav-logo" alt="" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="shop.php">Shop</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact Us</a>
          </li>
          <li class="nav-item">
            <a href="cart.php"><i class="fas fa-shopping-bag">
                <?php if(isset($_SESSION['quantity']) && $_SESSION['quantity']!= 0) {?>
                  <sup class="cart-quantity"><?php echo $_SESSION['quantity']; ?></sup>
                <?php } ?></i></a>
            <a href="account.php"><i class="fas fa-user"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <!--Search-->
  <section id="search" class="my-5 ms-2" style="padding: 8rem 0 !important;">
    <div class="container mt-5 py-4">
      <p style="margin: 0; padding: 0;">Search Products</p>
      <hr style="margin: 10px; padding: 0;">
    </div>

    <form action="shop.php" method="POST">
      <div class="row mx-auto container">
        <div class="col-lg-12 col-md-12 col-sm-12">


          <p style="margin: 0; padding: 0;">Category</p>
          <hr style="margin: 10px; padding: 0; height: 2px !important;">
          <div class="form-check">
            <input required class="form-check-input" value=1 type="radio" name="category" id="category_one" <?php
              if(isset($category) && $category==1 ){echo 'checked' ;}?>>
            <label class="form-check-label" for="category_one">
              Sarees
            </label>
          </div>

          <div class="form-check">
            <input required class="form-check-input" value=2 type="radio" name="category" id="category_two" <?php
              if(isset($category) && $category==2 ){echo 'checked' ;}?>>
            <label class="form-check-label" for="category_two">
              Shirts
            </label>
          </div>

          <div class="form-check">
            <input required class="form-check-input" value=3 type="radio" name="category" id="category_three" <?php
              if(isset($category) && $category==3 ){echo 'checked' ;}?>>
            <label class="form-check-label" for="category_three">
              Skirt
            </label>
          </div>

         

        </div>
      </div>


      <div class="row mx-auto container mt-5">
        <div class="col-lg-12 col-md-12 col-sm-12">

          <p style="margin: 0; padding: 0;">Price</p>
          <hr style="margin: 10px; padding: 0; height: 2px !important;">
          <input type="range" class="form-range w-50" name="price" value="<?php if(isset($price)){echo $price;}else{ echo " 500";} ?>" min="500" max="3000" id="customRange2">

          <div class="w-50">
            <span style="float: left;">500</span>
            <span style="float: right;">3000</span>
          </div>
        </div>
      </div>
      
      
      
      <!-- <output name="ageOutputName" id="ageOutputId">0</output> -->
      <div class="form-group my-3 mx-3">
        <input type="submit" name="search" value="Search" class="btn btn-primary" style="margin-left: 20px; margin-top: 20px;">
      </div>

      <form>

  </section>


  <!-- Shop  -->
  <section id="shop" class="my-5 py-5">
    <div class="container mt-5 py-4">
      <h3>Our Products</h3>
      <hr />
    </div>



    <div class="row mx-auto container">

<?php if(!isset($_GET['selected_category'])) { ?>

    <?php while($row = $products->fetch_assoc()){ ?>

      <div onclick="window.location.href='single_product.php?product_id=<?php echo $row['product_id']; ?>'" class="product text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" alt="" />
        <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
        <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
        <a class="btn buy-btn" href='single_product.php?product_id=<?php echo $row['product_id']; ?>'>Buy Now</a>
      </div>

    <?php } ?>

<?php } else { ?>

<!-- saree -->
    <?php if($_GET['selected_category']=="saree") {?>

          <?php  
          $stmt3 = $conn->prepare("SELECT * FROM products WHERE prod_category=1 LIMIT $offset,$total_records_per_page");

          $stmt3->execute();

          $saree_products = $stmt3->get_result();
          ?>

              <?php while($row = $saree_products->fetch_assoc()){ ?>

                  <div onclick="window.location.href='single_product.php?product_id=<?php echo $row['product_id']; ?>'" class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" alt="" />
                    <div class="star">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                    <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                    <a class="btn buy-btn" href='single_product.php?product_id=<?php echo $row['product_id']; ?>'>Buy Now</a>
                  </div>

              <?php } ?>

    <?php } ?>

<!-- shirt -->

    <?php if($_GET['selected_category']=="shirt") {?>

          <?php  
          $stmt3 = $conn->prepare("SELECT * FROM products WHERE prod_category=2 LIMIT $offset,$total_records_per_page");

          $stmt3->execute();

          $shirt_products = $stmt3->get_result();

          ?>
              <?php while($row = $shirt_products->fetch_assoc()){ ?>

                  <div onclick="window.location.href='single_product.php?product_id=<?php echo $row['product_id']; ?>'" class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" alt="" />
                    <div class="star">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                    <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                    <a class="btn buy-btn" href='single_product.php?product_id=<?php echo $row['product_id']; ?>'>Buy Now</a>
                  </div>

              <?php } ?>

    <?php } ?>

<!-- skirt -->

    <?php if($_GET['selected_category']=="skirt") {?>

          <?php  
          $stmt3 = $conn->prepare("SELECT * FROM products WHERE prod_category=3 LIMIT $offset,$total_records_per_page");

          $stmt3->execute();

          $skirt_products = $stmt3->get_result();
          ?>

              <?php while($row = $skirt_products->fetch_assoc()){ ?>

                  <div onclick="window.location.href='single_product.php?product_id=<?php echo $row['product_id']; ?>'" class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" alt="" />
                    <div class="star">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                    <h4 class="p-price"><?php echo $row['product_price']; ?></h4>
                    <a class="btn buy-btn" href='single_product.php?product_id=<?php echo $row['product_id']; ?>'>Buy Now</a>
                  </div>

              <?php } ?>

    <?php } ?>

<?php } ?>


<!-- Pagination -->
<nav aria-label="Page navigation example">
  <ul class="pagination mt-5">
    <?php ?>
          <li class="page-item <?php if($page_no <= 1) {echo 'disabled';}?>">
            <a class="page-link" href="<?php if($page_no <= 1) {echo '#';} else {echo "?page_no=".($page_no-1);} ?>">Previous</a>
          </li>
          <li class="page-item"><a href="?page_no=1" class="page-link">1</a></li>
          <li class="page-item"><a href="?page_no=2" class="page-link">2</a></li>

          <?php if($page_no >= 3) {?>
            <li class="page-item"><a href="" class="page-link">...</a></li>
            <li class="page-item"><a href="<?php echo "?page_no=".$page_no; ?>" class="page-link"><?php echo $page_no; ?></a></li>            
          <?php } ?>

          <li class="page-item <?php if($page_no >= $total_no_of_pages){echo 'disabled';} ?>">
          <a href="<?php if($page_no >= $total_no_of_pages) {echo '#';} else{echo "?page_no=".($page_no+1);} ?>" class="page-link">Next</a>
        </li>
        </ul>
      </nav>

    </div>
  </section>


  
<?php include('layouts/footer.php') ?>