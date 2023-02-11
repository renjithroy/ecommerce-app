<?php include('layouts/header.php') ?>

  <!-- HOME -->
  <section id="home">
    <div class="container">
      <!-- <h5>NEW ARRIVALS</h5> -->
      <h1 class="pb-2"><span>Discover the magic</span> of handwoven clothes</h1>
      <p class="pb-2">Weaved offers the best products for the most affordable prices</p>
      <button onclick="window.location.href='shop.php';">Shop Now</button>
    </div>
  </section>

  <!-- <section id="brand" class="container">
        <div class="row">
            <img src="assets/imgs/banner/ok1.jpeg" class="img-fluid col-lg-3 col-md-6 col-sm-12">
            <img src="assets/imgs/banner/cottonrack.png" class="img-fluid col-lg-3 col-md-6 col-sm-12">
            <img src="assets/imgs/banner/southloom.png" class="img-fluid col-lg-3 col-md-6 col-sm-12">
            <img src="assets/imgs/banner/kashmirloom.png" class="img-fluid col-lg-3 col-md-6 col-sm-12">
        </div>
    </section> -->

  <!-- New -->
  <section id="new" class="w-100">
    <div class="row p-0 m-0">

      <!-- one -->
      <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
        <img class="img-fluid" src="assets/imgs/banner/saree 600px crop.jpg" alt="" />
        <div class="details">
          <h2>Sarees</h2>
          <button class="text-uppercase" onclick="location.href='shop.php?selected_category=saree';" >Shop Now</button>
        </div>
      </div>

      <!-- two -->
      <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
        <img class="img-fluid" src="assets/imgs/Shirt/Mens linen shirt/shirt1.jpg" alt="" />
        <div class="details">
          <h2>Shirts</h2>
          <button class="text-uppercase" onclick="location.href='shop.php?selected_category=shirt';">Shop Now</button>
        </div>
      </div>

      <!-- three -->
      <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
        <img class="img-fluid" src="assets/imgs/Skirt/Emerald midi linen skirt/skirt1.jpg" alt="" />
        <div class="details">
          <h2>Skirts</h2>
          <button class="text-uppercase" onclick="location.href='shop.php?selected_category=skirt';">Shop Now</button>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured section -->
  <section id="featured" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
      <h3>Featured Shirts</h3>
      <hr class="mx-auto" />
      <p>Here you can check out our featured products</p>
    </div>
    <div class="row mx-auto container-fluid">

    <?php include('server/get_featured_products.php'); ?>
    
    <?php while($row = $featured_products->fetch_assoc()){ ?>

      <div onclick="window.location.href='single_product.php?product_id=<?php echo $row['product_id']; ?>'" class="product text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?> ">
        <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
        <h4 class="p-price">₹ <?php echo $row['product_price']; ?></h4>
        <a href="<?php echo "single_product.php?product_id=".$row['product_id'];?>"><button class="buy-btn">Buy Now</button></a> 
      </div>
      
      <?php }?>

    </div>
  </section>

  <!-- Banner section -->
  <section id="banner" class="my-5 py-5">
    <div class="container">
      <h4>MID SEASON'S SALE</h4>
      <h1>
        Explore The Handcrafts<br />
        Up to 30% OFF
      </h1>
      <button class="text-uppercase" onclick="location.href='shop.php';">Shop Now</button>
    </div>
  </section>

  <!-- Clothes/Saree -->
  <section id="featured" class="my-5">
    <div class="container text-center mt-5 py-5">
      <h3>Featured Sarees</h3>
      <hr class="mx-auto" />
      <p>Checkout our collections!</p>
    </div>
    <div class="row mx-auto container-fluid">

    <?php include('server/get_sarees.php'); ?>

    <?php while($row = $saree_products->fetch_assoc()){ ?>

      <div onclick="window.location.href='single_product.php?product_id=<?php echo $row['product_id']; ?>'" class="product text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
        <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
        <h4 class="p-price">₹ <?php echo $row['product_price']; ?></h4>
        <a href="<?php echo "single_product.php?product_id=".$row['product_id'];?>"><button class="buy-btn">Buy Now</button></a> 
        
      </div>
      
      <?php } ?>

    </div>
  </section>

  <!-- Skirts -->
  <section id="watches" class="my-5">
    <div class="container text-center mt-5 py-5">
      <h3>Featured Skirts</h3>
      <hr class="mx-auto" />
      <p>Checkout our trending arrivals</p>
    </div>

    <div class="row mx-auto container-fluid">

    <?php include('server/get_skirts.php'); ?>
    <?php while($row = $skirts->fetch_assoc()){ ?>

      <div onclick="window.location.href='single_product.php?product_id=<?php echo $row['product_id']; ?>'" class="product text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
        <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
        <h4 class="p-price">₹ <?php echo $row['product_price']; ?></h4>
        <a href="<?php echo "single_product.php?product_id=".$row['product_id'];?>"><button class="buy-btn">Buy Now</button></a> 
      </div>

      <?php } ?>

    </div>
  </section>

  <!-- Shoes -->
  <!-- <section id="shoes" class="my-5">
    <div class="container text-center mt-5 py-5">
      <h3>Shoes</h3>
      <hr class="mx-auto" />
      <p>Checkout our amazing shoes</p>
    </div>
    <div class="row mx-auto container-fluid">
      <div class="product text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="assets/images/shoes1.jpeg" alt="" />
        <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <h5 class="p-name">Sports Shoes</h5>
        <h4 class="p-price">$199.8</h4>
        <button class="buy-btn">Buy Now</button>
      </div>
      <div class="product text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="assets/images/shoes2.jpeg" alt="" />
        <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <h5 class="p-name">Sports Shoes</h5>
        <h4 class="p-price">$199.8</h4>
        <button class="buy-btn">Buy Now</button>
      </div>
      <div class="product text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="assets/images/shoes3.jpeg" alt="" />
        <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <h5 class="p-name">Sports Shoes</h5>
        <h4 class="p-price">$199.8</h4>
        <button class="buy-btn">Buy Now</button>
      </div>
      <div class="product text-center col-lg-3 col-md-4 col-sm-12">
        <img class="img-fluid mb-3" src="assets/images/shoes4.jpeg" alt="" />
        <div class="star">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
        </div>
        <h5 class="p-name">Sports Shoes</h5>
        <h4 class="p-price">$199.8</h4>
        <button class="buy-btn">Buy Now</button>
      </div>
    </div>
  </section> -->


<?php include('layouts/footer.php') ?>
