<?php include('layouts/header.php') ?>
<?php
// session creates a file in a temporary directory on the server where registered session variables and their values are stored

//checks if a session is already started and if none is started then it starts one

// isset checks whether the user reached here using the add to cart button on single_product.php page

//we reach here from single_product.php by collecting product info through a form
if(isset($_POST['add_to_cart'])){
    
  //if user has already added a product to the cart,i.e if something is already present in the the cart (isset)
  if(isset($_SESSION['cart'])){ //cart empty or not. To check duplication


    $products_array_ids = array_column($_SESSION['cart'],"product_id"); //returns ids of already added products to the cart   
    // if product has already been added to cart or not
    if(!in_array($_POST['product_id'], $products_array_ids) ){

      $product_id = $_POST['product_id'];

      $product_array = array(
            'product_id' => $_POST['product_id'],
            'product_name' => $_POST['product_name'], 
            'product_price' => $_POST['product_price'],
            'product_image' => $_POST['product_image'],
            'product_quantity' => $_POST['product_quantity'],
            'product_size' => $_POST['product_size'],
      );
      $_SESSION['cart'][$product_id] = $product_array;

    }else{
      // echo '<script>alert("Product was already added to cart");</script>';
    }
    
  }else{
    //if no cart session is set just add the product to the session.
    //if this is the first product, session is initiated
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price  = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];
    $product_size = $_POST['product_size'];

    $product_array = array(
          'product_id' => $product_id,
          'product_name' => $product_name,
          'product_price' => $product_price,
          'product_image' => $product_image,
          'product_quantity' => $product_quantity,
          'product_size' => $product_size,
    );

      $_SESSION['cart'][$product_id] = $product_array;
        // Created a session and that session is an array
        // Structure of session array = [ 2=>[], 5=>[] ] 
        // Each array added to cart will have an unique id. In order to recognise each product array we need to give it an id
        // We will have key value pairs inside the session array, key is the unique id and array is each product array
  }

  //calculate total
  calculateTotalCart();


}else if(isset($_POST['remove_product'])){ //remove product from cart

  $product_id = $_POST['product_id'];
  unset($_SESSION['cart'][$product_id]); //remove product with that product id

    //calculate total
  calculateTotalCart();

}else if(isset($_POST['edit_quantity']) ){
  //we get id and quantity from form in this page (edit section)
  $product_id = $_POST['product_id']; 
  $product_quantity = $_POST['product_quantity']; //new quantity
  
  //get product array from session
  $product_array = $_SESSION['cart'][$product_id]; //returns specific array of the product

  //update product quantity
  $product_array['product_quantity'] = $product_quantity;

  //return array back to its place/session
  $_SESSION['cart'][$product_id] = $product_array;

    //calculate total
  calculateTotalCart();

}else{
  //header('location: index.php');
}

function calculateTotalCart(){

  $total_price = 0;
  $total_quantity = 0;

  foreach($_SESSION['cart'] as $key => $value){

    $product = $_SESSION['cart'][$key]; //$key = product_id
    
    $price = $product['product_price'];
    $quantity = $product['product_quantity'];

    $total_price = $total_price + ($price * $quantity); // first product total is added, second product total is added to first product total, and so on
    $total_quantity = $total_quantity + $quantity; // to record no.of items in cart

  }

  $_SESSION['total'] = $total_price;
  $_SESSION['quantity'] = $total_quantity;

}

?>


  <!-- Cart -->
  <section class="cart container my-5 py-5">
    <div class="container mt-5">
      <h2 class="font-weight-bold">Your Cart</h2>
      <hr style="width: 135px" />
    </div>
    <table class="mt-5 pt-5">
      <tr>
        <th>Product</th>
        <th>Quantity</th>
        <th>Sub-total</th>
      </tr>
      <!-- if cart is empty -->
      <?php if(empty($_SESSION['cart'])) {?>
        <tr>
          <td style="font-size: 22px;">Your Cart is Empty</td>
          <td></td>
          <td></td>
        </tr>
      <?php } ?>
      <!-- Only if there is something in the cart it is displayed - to prevent error -->
      <?php if(isset($_SESSION['cart'])) {?>
      <?php foreach($_SESSION['cart'] as $key => $value){ ?>
      <tr>
        <td>
          <div class="product-info">
            <img src="assets/imgs/<?php echo $value['product_image']; ?>"/>
            <div>
              <p><?php echo $value['product_name']; ?></p>
              <small><span>₹ </span><?php echo $value['product_price']; ?></small>
              <br />
              <form method="POST" action="cart.php">
                  <input name="product_id" type="hidden" value=<?php echo $value['product_id'] ?>>
                  <input name="remove_product" class="remove-btn" type="submit" value="remove">
              </form>
            </div>
          </div>
        </td>
        <td>
          <form method="POST" action="cart.php">
              <input type="hidden" value="<?php echo $value['product_id']; ?>" name="product_id">  
              <input type="number" value="<?php echo $value['product_quantity'];?>" name="product_quantity" min="1" max="5"/>
              <input type="submit" class="edit-btn" value="edit" name="edit_quantity">  
          </form>
        </td>
        <td>
          <span>₹</span>
          <span class="product-price"><?php echo $value['product_quantity'] * $value['product_price']; ?></span>
        </td>
      </tr>
      <?php } ?>
      <?php } ?>
    </table>
          
    <!-- Only if total has a value it is displayed - to prevent error -->
    <?php if(isset($_SESSION['total']) && $_SESSION['total']!=0) {?>
    <div class="cart-total">
      <table>
        <tr>
          <td>Total</td>
          <td>₹ <?php echo $_SESSION['total']; ?></td>
        </tr>
      </table>
    </div>
    
    <div class="checkout-container">
      <form action="checkout.php" method="POST">
        <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout">
      </form>
    </div>
    <?php } ?>
    
  </section>



  
<?php include('layouts/footer.php') ?>
