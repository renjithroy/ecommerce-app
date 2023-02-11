<?php include('header.php'); ?>

<?php 

  if(!isset($_SESSION['admin_logged_in'])) {
      header('location: login.php');
      exit;
  
  }

?>

<?php

if(isset($_GET['order_id'])){ 

    $order_id = $_GET['order_id'];

    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id=?");

    $stmt->bind_param('i',$order_id);

    $stmt->execute();

    $order = $stmt->get_result();

}

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
    padding: 7px 6px !important;
    font-weight: 400;
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
        <h1 class="h2" style="padding-left: 28rem">Product details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
          
          </div>
     
        </div>
      </div>

      <div class="table-responsive" style="margin-top: 23px !important">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col" class="text-center">Product Id</th>
              <th scope="col" class="text-center">Product Name</th>
              <th scope="col" class="text-center">Product Image</th>
              <th scope="col" class="text-center">Product Price</th>
              <th scope="col" class="text-center">Product Quantity</th>
              <th scope="col" class="text-center">Product Size</th>
            </tr>
          </thead>
          <tbody style="padding: 50px !important; vertical-align: middle !important;" >
            <?php foreach($order as $item) { ?>
                <tr>
                  <td class="text-center"><?php echo $item['product_id'] ?></td>
                  <td class="text-center"><?php echo $item['product_name'] ?></td>
                  <td class="text-center"><img style="width: 90px; height: 85px;" class="img-fluid" src="../assets/imgs/<?php echo $item['product_image'];?>"></td>
                  <td class="text-center"><?php echo $item['product_price'] ?></td>
                  <td class="text-center"><?php echo $item['product_quantity'] ?></td>
                  <td class="text-center"><?php echo $item['product_size'] ?></td>
                </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </main>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
