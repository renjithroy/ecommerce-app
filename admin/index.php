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

    $stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM orders"); //returns total no.of products in database

    $stmt1->execute(); //executes the sql query

    $stmt1->bind_result($total_records); //stores result into a variable as array (its an array of result)

    $stmt1->store_result();

    $stmt1->fetch();

  //3. set total no.of products per page

    $total_records_per_page = 10;
    
    $offset = ($page_no-1) * $total_records_per_page;

    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $adjacents = "2";

    $total_no_of_pages = ceil($total_records/$total_records_per_page); //ex- 12/8 = 1.5 which is ceiled so 2 pages of products

  //4. Get all products

    $stmt2 = $conn->prepare("SELECT * FROM orders ORDER BY order_id DESC LIMIT $offset,$total_records_per_page");

    $stmt2->execute();

    $orders = $stmt2->get_result();

?>

<style>
table {
    border-collapse: collapse;
    font-size: 14px;
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

table thead tr th{
    padding: 10px 6px !important;
    font-weight: 400;
}

.pagination li a{
    color: #fb774b !important;
}

</style>



<div class="container-fluid mt-3">
  <div class="row" style="min-height: 1000px">

    <?php include('sidemenu.php') ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 ">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2" style="padding-left: 28rem">Manage Orders</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
          
          </div>
     
        </div>
      </div>

        <?php if(isset($_GET['order_updated'])) {?>
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
            "><?php echo $_GET['order_updated'];?></div>
        <?php } ?>

        <?php if(isset($_GET['order_failed'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['order_failed']; ?></p>
        <?php } ?>

    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>

      <div class="table-responsive">
        <table class="table table-striped table-sm text-center sortable">
          <thead>
            <tr class="text-center">
              <th scope="col">Order Id</th>
              <th scope="col">Order Status</th>
              <th scope="col">User Id</th>
              <th scope="col">Order Date</th>
              <th scope="col">User Name</th>
              <th scope="col">User Email</th>
              <th scope="col">User Phone</th>
              <th scope="col">User Address</th>
              <th scope="col">Edit Order</th>
              <th scope="col">View Product</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($orders as $order) { ?>
                <tr>
                  <td><?php echo $order['order_id'] ?></td>
                  <td><?php echo $order['order_status'] ?></td>
                  <td><?php echo $order['user_id'] ?></td>
                  <td><?php echo $order['order_date'] ?></td>
                  <td><?php echo $order['user_name'] ?></td>
                  <td><?php echo $order['user_email'] ?></td>
                  <td><?php echo $order['user_phone'] ?></td>
                  <td><?php echo $order['user_address'] ?></td>
                  <td style="padding: 15px;"><a style="background-color: #fb774b; color: #fff; padding: 10px; text-decoration: none; border-radius: 4px;" href="edit_order.php?order_id=<?php echo $order['order_id']; ?>">Edit</a></td>
                  <td style="padding: 15px;"><a style="background-color: #0047AB; color: #fff; padding: 10px; text-decoration: none; border-radius: 4px;" href="view_ordered_product.php?order_id=<?php echo $order['order_id']; ?>">View</a></td>
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
