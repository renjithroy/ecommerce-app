<?php include('layouts/header.php') ?>

<?php
include('server/connection.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id']; //stores product id from url to a variable

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");

    $stmt->bind_param("i", $product_id); //fills the ? with product_id, i = integer

    $stmt->execute(); //executes the sql query

    $product = $stmt->get_result(); //stores result into a variable as array (its an array of result)
} else {
    header('location: index.php'); //We cannot get to single_product.php without any product details
}

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .inclusive{
    color: #03a685;
    font-weight: 500;
    font-size: 14px;
    display: block;
    margin: 5px 10px 0 20px;
}
    .discount{
    font-size: 17px;
    font-weight: 500;
    letter-spacing: .5px;
    color: #ff905a;
}

}
</style>
<!--Temporary img for product images switching -->
<img class="temp-img" src="" alt="">

<!-- Single Product -->
<section class="container single-product my-5 pt-2">
    <div class="row mt-5">

        <?php while ($row = $product->fetch_assoc()) { ?>
        <div class="col-lg-5 col-md-6 col-sm-12">
            <img src="assets/imgs/<?php echo $row['product_image']; ?>" class="img-fluid w-100 pb-1" id="mainImg" />
            <div class="small-img-group">
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image']; ?>" width="100%" class="small-img" />
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image2']; ?>" width="100%" class="small-img" />
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image3']; ?>" width="100%" class="small-img" />
                </div>
                <div class="small-img-col">
                    <img src="assets/imgs/<?php echo $row['product_image4']; ?>" width="100%" class="small-img" alt="" />
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
            <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
            <h3 class="mb-1 d-inline" id="price">₹ <?php echo $row['product_price']; ?></h3>
            <?php if($row['product_special_offer']!==0){ ?>
            <span class="discount">( <?php echo $row['product_special_offer']; ?> % OFF)</span>
            <?php } ?>
            <span class="inclusive">inclusive of all taxes</span>

            <!-- for related products -->

            <?php $category = $row['prod_category']; ?>

            <?php

                        $stmt2 = $conn->prepare("SELECT * FROM products WHERE prod_category = ? AND product_id <> ? LIMIT 4");

                        $stmt2->bind_param("si", $category, $product_id); //fills the ? with product_id, i = integer

                        $stmt2->execute(); //executes the sql query

                        $related_product = $stmt2->get_result(); //stores result into a variable as array (its an array of result)


                ?>

            <!-- Capturing the details of the product using a form to add into cart page  -->
            <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>" />
                <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>" />
                <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>" />
                <input type="hidden" name="product_size" value="<?php echo $row['product_size']; ?>" />
                <br>
                <label class="d-inline">Select Quantity: </label>
                <input class="form-control d-inline" type="number" name="product_quantity" value="1" min="1" max="5"/>
                <br>
                <br>
                <label class="d-inline">Select Size: </label>
                <select class="form-select w-25 d-inline mb-2" name="product_size">
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
                <br>
                <br>
                <button class="buy-btn" type="submit" name="add_to_cart" style="border-radius: 5px; font-size: 15px;"><i class="fa-solid fa-cart-shopping" style="font-size: 15px; margin-right: 20px;"></i>Add To Cart</button>
                <span class="d-block mt-4 pb-1" style="font-weight: 300;">100% Original Products</span>
                <span class="d-block pb-1" style="font-weight: 300;">Easy 30 days returns and exchanges</span>
                <span class="d-block pb-1" style="font-weight: 300;">Try & Buy might be available</span>
                <h4 class="mt-4 mb-4">PRODUCT DETAILS</h4>
                <span style="font-weight: 300;"><?php echo $row['product_description']; ?></span>
                <br/>
                <br/>
            </form>

        </div>
        <?php }?>

    </div>
</section>

<!-- Related products -->
<section id="related-products" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Related Products</h3>
        <hr class="mx-auto" />
    </div>
    <div class="row mx-auto container-fluid">
        <?php while ($r = $related_product->fetch_assoc()) { ?>
        <div onclick="window.location.href='single_product.php?product_id=<?php echo $r['product_id']; ?>'" class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $r['product_image']; ?>" />
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name"><?php echo $r['product_name']; ?></h5>
            <h4 class="p-price">₹ <?php echo $r['product_price']; ?></h4>
            <button class="buy-btn">Buy Now</button>
        </div>
        <?php } ?>
    </div>
</section>

<?php include('layouts/footer.php') ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script>
var mainImg = document.getElementById("mainImg");
var smallImg = document.getElementsByClassName("small-img"); //returns array of small images
var tempImg = document.getElementsByClassName("temp-img");

for (let i = 0; i < 4; i++) {
    smallImg[i].onclick = function() {
        tempImg.src = mainImg.src;
        mainImg.src = smallImg[i].src;
        smallImg[i].src = tempImg.src;
    };
}
</script>

</body>

</html>