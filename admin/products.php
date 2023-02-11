<?php include('header.php'); ?>

<?php 

  if(!isset($_SESSION['admin_logged_in'])) {
      header('location: login.php');
      exit;
  
  }

?>

<?php

   //1. Determine page no

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

    $total_records_per_page = 6;
    
    $offset = ($page_no-1) * $total_records_per_page;

    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $adjacents = "2";

    $total_no_of_pages = ceil($total_records/$total_records_per_page); //ex- 12/8 = 1.5 which is ceiled so 2 pages of products

  //4. Get all products

    $stmt2 = $conn->prepare("SELECT * FROM products LIMIT $offset,$total_records_per_page");

    $stmt2->execute();

    $products = $stmt2->get_result();

?>

<style>
  table {
    border-collapse: collapse;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

table thead tr {
    background-color: #fb774b;
    color: #ffffff;
    text-align: left;
}

table th, table td {
    padding: 12px 15px;
}


table tbody tr {
    border-bottom: thin solid #dddddd;
}
table thead tr th{
    padding: 10px 6px !important;
    font-weight: 400;
}
table tbody tr:nth-of-type(even){
    background-color: #fff;
}

table tbody tr:last-of-type {
    border-bottom: 2px solid #fb774b;
}

table tbody tr.active-row {
    font-weight: bold;
    color: #009879;
}

.pagination li a{
    color: #fb774b !important;
}

</style>


<div class="container-fluid">
  <div class="row" style="min-height: 1000px">

    <?php include('sidemenu.php') ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 ">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" style="margin-bottom: 20px !important;">
        <h1 class="h2" style="padding-left: 28rem">Manage Products</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
          
          </div>
     
        </div>
      </div>



        <?php if(isset($_GET['edit_success_message'])) {?>
            <div style=" width:33%;
            color: green;
            background-color: #ffffff;
            padding:20px;
            border:1px solid #eee;
            border-left-width:5px;
            border-radius: 3px;
            margin: 0 auto 30px auto;
            font-size: 15px;
            border-left-color: #2b542c;
            background-color: rgba(43, 84, 44, 0.1);
            "><?php echo $_GET['edit_success_message'];?></div>
        <?php } ?>

        <?php if(isset($_GET['edit_failure_message'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['edit_failure_message']; ?></p>
        <?php } ?>

        <!-- Deleting products -->

        <?php if(isset($_GET['deleted_successfully'])) {?>
            <div style=" width:33%;
            color: green;
            background-color: #ffffff;
            padding:20px;
            border:1px solid #eee;
            border-left-width:5px;
            border-radius: 3px;
            margin: 0 auto 30px auto;
            font-size: 15px;
            border-left-color: #2b542c;
            background-color: rgba(43, 84, 44, 0.1);
            "><?php echo $_GET['deleted_successfully'];?></div>
        <?php } ?>

        <?php if(isset($_GET['deleted_failure'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['deleted_failure']; ?></p>
        <?php } ?>

        <!-- Adding new products -->

        <?php if(isset($_GET['product_created'])) {?>
            <div style=" width:33%;
            color: green;
            background-color: #ffffff;
            padding:20px;
            border:1px solid #eee;
            border-left-width:5px;
            border-radius: 3px;
            margin: 0 auto 30px auto;
            font-size: 15px;
            border-left-color: #2b542c;
            background-color: rgba(43, 84, 44, 0.1);
            "><?php echo $_GET['product_created'];?></div>
        <?php } ?>

        <?php if(isset($_GET['product_failed'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['product_failed']; ?></p>
        <?php } ?>

        <!-- image updation -->

        <?php if(isset($_GET['images_updated'])) {?>
            <div style=" width:33%;
            color: green;
            background-color: #ffffff;
            padding:20px;
            border:1px solid #eee;
            border-left-width:5px;
            border-radius: 3px;
            margin: 0 auto 30px auto;
            font-size: 15px;
            border-left-color: #2b542c;
            background-color: rgba(43, 84, 44, 0.1);
            "><?php echo $_GET['images_updated'];?></div>
        <?php } ?>

        <?php if(isset($_GET['images_failed'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['images_failed']; ?></p>
        <?php } ?>

      <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>

      <div class="table-responsive" style="margin-top: 23px !important">
        <table class="table table-striped table-sm text-center sortable">
          <thead>
            <tr class="text-center">
              <th scope="col">Product Id</th>
              <th scope="col">Product Image</th>
              <th scope="col">Product Name</th>
              <th scope="col">Product Price</th>
              <th scope="col">Product Offer</th>
              <th scope="col">Product Category</th>
              <th scope="col">Product Color</th>
              <th scope="col">Edit Images</th>
              <th scope="col">Edit Product</th>
              <th scope="col">Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($products as $product) { ?>
                <tr>
                  <td><?php echo $product['product_id'] ?></td>
                  <td> <img src="<?php echo "../assets/imgs/".$product['product_image']; ?>" style="width: 70px; height: 70px;"></td>
                  <td><?php echo $product['product_name'] ?></td>
                  <td><?php echo "₹". $product['product_price'] ?></td>
                  <td><?php echo $product['product_special_offer']."%" ?></td>
                  <td>
                      <?php 
                      
                            $prod_cat = $product['prod_category'];

                            $stmt3 = $conn->prepare("SELECT cat_description FROM category WHERE id=?");

                            $stmt3->bind_param('i',$prod_cat);

                            $stmt3->execute();
  
                            $stmt3->bind_result($category); 

                            $stmt3->store_result();

                            $stmt3->fetch();

                            echo $category;
                      
                      ?>
                  </td>
                  <td><?php echo $product['product_color'] ?></td>
                  <td><a class="btn btn-warning" href="<?php echo "edit_images.php?product_id=".$product['product_id']."&product_name=".$product['product_name'];?>" style="font-size: 14px; color: white;">Edit Img</a></td>
                  <td><a class="btn btn-primary" href="edit_product.php?product_id=<?php echo $product['product_id']; ?>" style="font-size: 15px;">Edit</a></td>
                  <td><a class="btn btn-danger" href="delete_product.php?product_id=<?php echo $product['product_id']; ?>" style="font-size: 15px;">Delete</a></td>
                </tr>
            <?php } ?>
          </tbody>
        </table>

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
    </main>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
