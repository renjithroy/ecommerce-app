<?php include('header.php'); ?>
<?php 

  if(!isset($_SESSION['admin_logged_in'])) {
      header('location: login.php');
      exit;
  
  }

?>


<?php

  if(isset($_GET['product_id'])) 
  { 

  //getting the product id thats passed through url from the edit button

  $product_id = $_GET['product_id'];

  $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");

  $stmt->bind_param('i',$product_id);

  $stmt->execute();

  $products = $stmt->get_result();

  }
  else if(isset($_POST['edit_btn']))
  {
    $product_id = $_POST['product_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $offer = $_POST['offer'];
    $color = $_POST['color'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("UPDATE products SET product_name=?, product_description=?, product_price=?,
    product_special_offer=?, product_color=?, prod_category=? WHERE product_id=?");

    $stmt->bind_param('sssssii',$title,$description,$price,$offer,$color,$category,$product_id);

        if($stmt->execute())
        {
            header('location: products.php?edit_success_message=Product details updated successfully');
        }
        else
        {
            header('location: products.php?edit_fail_message=Error occured, please try again');
        }


  }
  else
  {
      header('products.php');
      exit;
  }



?>



<div class="container-fluid">
  <div class="row"  style="min-height: 1000px">

    <?php include('sidemenu.php') ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2" style="padding-left: 28rem">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
          
          </div>
     
        </div>
      </div>

    

      <h3 style="padding-bottom: 1rem; padding-top: 0.5rem">Edit Product</h3>
      <div class="table-responsive">
      


          <div class="mx-auto container">
              <form id="edit-form"  method="POST" action="edit_product.php">
                <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
                <div class="form-group mt-2">
                  <?php foreach($products as $product) {?>

                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <label>Title</label>
                    <input value="<?php echo $product['product_name'] ?>" type="text" class="form-control" id="product-name" name="title" placeholder="Title" required/>
                </div>
                  <div class="form-group mt-2">
                      <label>Description</label>

                      <textarea name="description" id="product-desc" cols="30" rows="8" class="form-control" required><?php echo $product['product_description'] ?></textarea>
                  </div>
                  <div class="form-group mt-2">
                    <label>Price</label>
                    <input value="<?php echo $product['product_price'] ?>" type="number" class="form-control" id="product-price" name="price" placeholder="Price" required/>
                </div>
                
                <?php 
                      
                  $prod_cat = $product['prod_category'];

                  $stmt3 = $conn->prepare("SELECT cat_description FROM category WHERE id=?");

                  $stmt3->bind_param('i',$prod_cat);

                  $stmt3->execute();

                  $stmt3->bind_result($singleProductCategory); 

                  $stmt3->store_result();

                  $stmt3->fetch();

                ?>
                
                <?php

                  $stmt4 = $conn->prepare("SELECT * FROM category");

                  $stmt4->execute();

                  $category = $stmt4->get_result();
                      
                ?>

                <div class='form-group mt-2'>
                    <label>Current Category</label>
                          <select class="form-select" disabled>
                                <?php
                                    // $category_id = $row['id'];
                                    // $category_description = $row['cat_description'];

                                    echo "
                                            <option value='$prod_cat'>
                                            $singleProductCategory
                                            </option>
                                    ";

                                ?>
                          </select>
                </div>

                <div class='form-group mt-2'>
                    <label>New Category</label>
                          <select class="form-select" name="category" required>
                                <?php
                                    while($row = $category->fetch_assoc() ){
                                    $category_id = $row['id'];
                                    $category_description = $row['cat_description'];

                                    if($singleProductCategory==$category_description){ //current product category is selected by default 
                                        echo "
                                                <option value='$category_id' selected> 
                                                $category_description
                                                </option>
                                        ";
                                    }

                                    if($singleProductCategory!=$category_description){ //remaining categories are listed
                                        echo "
                                                <option value='$category_id'>
                                                $category_description
                                                </option>
                                        ";
                                    }

                                    }
                                ?>
                          </select>
                </div>


                
                
                  <div class="form-group mt-2">
                      <label>Color</label>
                      <input value="<?php echo $product['product_color'] ?>" type="text" class="form-control" id="product-color" name="color" placeholder="Color" required/>
                  </div>

              <div class="form-group mt-2">
                    <label>Special Offer/Sale</label>
                    <input value="<?php echo $product['product_special_offer'] ?>" type="number" class="form-control" id="product-offer" name="offer" placeholder="Sale %" required/>
                </div>



                <div class="form-group mt-3">
                    <input type="submit" class="btn btn-primary" name="edit_btn" value="Edit"/>
                </div>
 
                <?php } ?>

              </form>
          </div>
    




      </div>
    </main>
  </div>
</div>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
