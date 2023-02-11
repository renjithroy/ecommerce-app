<?php session_start(); ?>

<?php include('../server/connection.php'); ?>


<?php 

  if(!isset($_SESSION['admin_logged_in'])) {
      header('location: login.php');
      exit;
  
  }

?>





<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Admin Panel</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

        <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.1/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.1/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.1/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">


<style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;400&display=swap");

      body {
        font-family: "Poppins", sans-serif;
      }

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

    .card-header {
        border-bottom: 1px solid transparent;
        background-color: transparent;
    }

    .divOne:hover{
        background-color: #1560bd;
        cursor: pointer;
        border: none !important;
    }
    
    .divOne:hover p{
        color: white !important;
    }

    .divOne:hover h5{
        color: white !important;
    }

    .divTwo{
      border: 1px solid #fb774b !important;
      color: #fb774b;
    }

    .divTwo:hover{
        background-color: #fb774b;
        cursor: pointer;
        border: none !important;
    }
    
    .divTwo:hover p{
        color: white !important;
    }

    .divTwo:hover h5{
        color: white !important;
    }

   .divThree:hover{
        background-color: #FDDA0D;
        cursor: pointer;
        border: none !important;
    }
    
    .divThree:hover p{
        color: white !important;
    }

    .divThree:hover h5{
        color: white !important;
    }
    
   .divFive:hover{
        background-color: #A30000 ;
        cursor: pointer;
        border: none !important;
    }
    
    .divFive:hover p{
        color: white !important;
    }

    .divFive:hover h5{
        color: white !important;
    }

    .divSix{
      border: 1px solid #54BAB9 !important;
      color: #54BAB9;
    }

    .divSix:hover{
        background-color: #18978F;
        cursor: pointer;
        border: none !important;
    }
    
    .divSix:hover p{
        color: white !important;
    }

    .divSix:hover h5{
        color: white !important;
    }

    select{
      padding: 5px !important;
    }

</style>
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
  </head>
  <body>
    


<div class="container-fluid">
  <div class="row" style="min-height: 1000px">

    <?php include('sidemenu.php') ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 ">

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" style="margin-bottom: 20px !important; border-bottom: none !important;">
        <h1 class="h2" style="padding-left: 28rem;">Dashboard</h1>
      </div>

    <form action="dashboard.php" method="POST" id="submitForm">
      <label for="timeFrameId">Select a time frame: </label>
        <select onchange="submitForm.submit()" name="timeFrame" id="timeFrameId" class="mb-4">
          <option value="allTime" <?php if(isset($_POST['timeFrame']) && $_POST['timeFrame'] == "allTime") { echo "selected"; } ?>>All time</option>
          <option value="sixMonth" <?php if(isset($_POST['timeFrame']) && $_POST['timeFrame'] == "sixMonth") { echo "selected"; } ?>>Last six months</option>
          <option value="lastMonth" <?php if(isset($_POST['timeFrame']) && $_POST['timeFrame'] == "lastMonth") { echo "selected"; } ?>>Previous month</option>
        </select>
    </form>

<?php $selectOption = $_POST['timeFrame']; ?>


<?php if($selectOption == "allTime" || $selectOption == '') { ?>

    <?php

      $stmt = $conn->prepare("SELECT COUNT(*) FROM payments"); //returns total no.of products in database

      $stmt->execute(); //executes the sql query

      $stmt->bind_result($total_rows); //stores result into a variable as array (its an array of result)

      $stmt->store_result();

      $stmt->fetch();

    ?>

    <?php

      $stmt1 = $conn->prepare("SELECT SUM(order_cost) FROM orders WHERE NOT order_status = 'not paid'"); //returns total no.of products in database

      $stmt1->execute();

      $stmt1->bind_result($total_revenue); //stores result into a variable as array (its an array of result)

      $stmt1->store_result();

      $stmt1->fetch();

    ?>

    <?php

      $stmt2 = $conn->prepare("SELECT COUNT(*) FROM products"); //returns total no.of products in database

      $stmt2->execute(); //executes the sql query

      $stmt2->bind_result($total_products); //stores result into a variable as array (its an array of result)

      $stmt2->store_result();

      $stmt2->fetch();

    ?>

    <?php

      $stmt3 = $conn->prepare("SELECT COUNT(*) FROM users"); //returns total no.of products in database

      $stmt3->execute(); //executes the sql query

      $stmt3->bind_result($total_users); //stores result into a variable as array (its an array of result)

      $stmt3->store_result();

      $stmt3->fetch();

    ?>

    <?php

      $stmt4 = $conn->prepare("SELECT COUNT(*) FROM admins"); //returns total no.of products in database

      $stmt4->execute(); //executes the sql query

      $stmt4->bind_result($total_admins); //stores result into a variable as array (its an array of result)

      $stmt4->store_result();

      $stmt4->fetch();

    ?>

      <?php

        $stmt5 = $conn->prepare("SELECT * FROM orders"); //for graph

        $stmt5->execute();

        $result = $stmt5->get_result();

      ?>

    <?php

      $stmt6 = $conn->prepare("SELECT COUNT(*) FROM orders WHERE NOT order_status = 'not paid'"); //returns ORDERS whose order status is not paid
      // $stmt6 = $conn->prepare("SELECT COUNT(*) FROM orders WHERE NOT order_status = 'not paid' AND order_date >= date_sub(now(),interval 12 month); "); //returns total no.of products in database
      $stmt6->execute(); //executes the sql query

      $stmt6->bind_result($total_orders); //stores result into a variable as array (its an array of result)

      $stmt6->store_result();

      $stmt6->fetch();

    ?>

    <!-- CHART -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Price'],
          <?php
            while($data=mysqli_fetch_array($result)){

          
              
              $date = $data['order_date']; 
              $price = $data['order_cost'];
              // $expenses = $data['expenses'];
              // $profit = $data['profit'];
          ?>
          ['<?php echo $date;?>',<?php echo $price;?>],
          <?php } ?>
        ]);

        var options = {
          chart: {
            title: 'Daily Sales Report',
          },
          bars: 'vertical', // Required for Material Bar Charts.
          colors: ['#fb774b', '#fb774b', '#fb774b', '#fb774b', '#fb774b']
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
  </script>


    <div class="card m-b-30">
            <center><h5 class="mt-4 mb-2">All Time Sales Report</h5></center>

        <div class="card-body">                 
            <div class="d-flex row justify-content-around" style="width:100%;">

                    <div class="divTwo border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='dashboard_details/paid_orders.php?option=allTimePaidOrders';">
                        <h5 class="card-title mb-1"><?php echo $total_orders; ?></h5>
                        <p class="mb-0">Paid Orders</p>
                    </div>

                    <div class="divOne border-primary border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='dashboard_details/view_payments.php?option=allTimePayments';">
                        <h5 class="card-title text-primary mb-1"><?php echo $total_rows; ?></h5>
                        <p class="text-primary mb-0">Total Payments</p>
                    </div>
            
                    <div class="divTwo border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='index.php';">
                        <h5 class="card-title mb-1">₹ <?php echo $total_revenue; ?></h5>
                        <p class="mb-0">Total Revenue</p>
                    </div>
                  
                    <div class="divThree border-warning border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='products.php';">
                        <h5 class="card-title text-warning mb-1"><?php echo $total_products; ?></h5>
                        <p class="text-warning mb-0">Total Products</p>
                    </div> 
                    
                    <div class="divFive border-danger border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='dashboard_details/admin_details.php';">
                        <h5 class="card-title text-danger mb-1"><?php echo $total_admins; ?></h5>
                        <p class="text-danger mb-0">Admins</p>
                    </div>

                    <div class="divSix rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='users.php';">
                        <h5 class="card-title mb-1"><?php echo $total_users; ?></h5>
                        <p class="mb-0">Registerd Users</p>
                    </div> 


              </div>
        </div>
      
        <center><div id="barchart_material" style="width: 900px; height: 500px; padding-left: 50px; padding-top: 30px; margin-bottom: 50px"></div></center>
    </div>



<?php } else if($selectOption == "sixMonth") { ?>

       <?php

      $stmt = $conn->prepare("SELECT COUNT(*) FROM payments WHERE payment_date >= date_sub(now(),interval 6 month);"); //returns total no.of products in database

      $stmt->execute(); //executes the sql query

      $stmt->bind_result($total_rows); //stores result into a variable as array (its an array of result)

      $stmt->store_result();

      $stmt->fetch();

    ?>

    <?php

      $stmt1 = $conn->prepare("SELECT SUM(order_cost) FROM orders WHERE NOT order_status = 'not paid' AND order_date >= date_sub(now(),interval 6 month);"); //returns total no.of products in database

      $stmt1->execute();

      $stmt1->bind_result($total_revenue); //stores result into a variable as array (its an array of result)

      $stmt1->store_result();

      $stmt1->fetch();

    ?>

    <?php

      $stmt2 = $conn->prepare("SELECT COUNT(*) FROM products"); //returns total no.of products in database

      $stmt2->execute(); //executes the sql query

      $stmt2->bind_result($total_products); //stores result into a variable as array (its an array of result)

      $stmt2->store_result();

      $stmt2->fetch();

    ?>

    <?php

      $stmt3 = $conn->prepare("SELECT COUNT(*) FROM users"); //returns total no.of products in database

      $stmt3->execute(); //executes the sql query

      $stmt3->bind_result($total_users); //stores result into a variable as array (its an array of result)

      $stmt3->store_result();

      $stmt3->fetch();

    ?>

    <?php

      $stmt4 = $conn->prepare("SELECT COUNT(*) FROM admins"); //returns total no.of products in database

      $stmt4->execute(); //executes the sql query

      $stmt4->bind_result($total_admins); //stores result into a variable as array (its an array of result)

      $stmt4->store_result();

      $stmt4->fetch();

    ?>

      <?php

        $stmt5 = $conn->prepare("SELECT * FROM orders WHERE order_date >= date_sub(now(),interval 6 month);"); //returns total no.of products in database

        $stmt5->execute();

        $result = $stmt5->get_result();

      ?>

    <?php

      $stmt6 = $conn->prepare("SELECT COUNT(*) FROM orders WHERE NOT order_status = 'not paid' AND order_date >= date_sub(now(),interval 6 month); "); //returns total no.of products in database

      $stmt6->execute(); //executes the sql query

      $stmt6->bind_result($total_orders); //stores result into a variable as array (its an array of result)

      $stmt6->store_result();

      $stmt6->fetch();

    ?>

    <!-- CHART -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Price'],
          <?php
            while($data=mysqli_fetch_array($result)){

          
              
              $date = $data['order_date']; 
              $price = $data['order_cost'];
              // $expenses = $data['expenses'];
              // $profit = $data['profit'];
          ?>
          ['<?php echo $date;?>',<?php echo $price;?>],
          <?php } ?>
        ]);

        var options = {
          chart: {
            title: 'Daily Sales Report',
          },
          bars: 'vertical', // Required for Material Bar Charts.
          colors: ['#fb774b', '#fb774b', '#fb774b', '#fb774b', '#fb774b']
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
  </script>


    <div class="card m-b-30">
            <center><h5 class="mt-4 mb-2">Last Six Months Sales Report</h5></center>

        <div class="card-body">                 
            <div class="d-flex row justify-content-around" style="width:100%;">

                    <div class="divTwo border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='dashboard_details/paid_orders.php?option=sixMonthPaidOrders';">
                        <h5 class="card-title mb-1"><?php echo $total_orders; ?></h5>
                        <p class="mb-0">Paid Orders</p>
                    </div>

                    <div class="divOne border-primary border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='dashboard_details/view_payments.php?option=sixMonthPayments';">
                        <h5 class="card-title text-primary mb-1"><?php echo $total_rows; ?></h5>
                        <p class="text-primary mb-0">Total Payments</p>
                    </div>
            
                    <div class="divTwo border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='index.php';">
                        <h5 class="card-title mb-1">₹ <?php echo $total_revenue; ?></h5>
                        <p class="mb-0">Total Revenue</p>
                    </div>
                  
                    <div class="divThree border-warning border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='products.php';">
                        <h5 class="card-title text-warning mb-1"><?php echo $total_products; ?></h5>
                        <p class="text-warning mb-0">Total Products</p>
                    </div> 
                    
                    <div class="divFive border-danger border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='dashboard_details/admin_details.php';">
                        <h5 class="card-title text-danger mb-1"><?php echo $total_admins; ?></h5>
                        <p class="text-danger mb-0">Admins</p>
                    </div>

                    <div class="divSix rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='users.php';">
                        <h5 class="card-title mb-1"><?php echo $total_users; ?></h5>
                        <p class="mb-0">Registerd Users</p>
                    </div> 


              </div>
        </div>
      
        <center><div id="barchart_material" style="width: 900px; height: 500px; padding-left: 50px; padding-top: 30px; margin-bottom: 50px"></div></center>
    </div>
    
<?php } else if($selectOption == "lastMonth"){ ?>

    <?php

      $stmt = $conn->prepare("SELECT COUNT(*) FROM payments WHERE YEAR(payment_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(payment_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)"); //returns total no.of products in database

      $stmt->execute(); //executes the sql query

      $stmt->bind_result($total_rows); //stores result into a variable as array (its an array of result)

      $stmt->store_result();

      $stmt->fetch();

    ?>

    <?php

      $stmt1 = $conn->prepare("SELECT SUM(order_cost) FROM orders WHERE NOT order_status = 'not paid' AND YEAR(order_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(order_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)"); //returns total no.of products in database

      $stmt1->execute();

      $stmt1->bind_result($total_revenue); //stores result into a variable as array (its an array of result)

      $stmt1->store_result();

      $stmt1->fetch();

    ?>

    <?php

      $stmt2 = $conn->prepare("SELECT COUNT(*) FROM products"); //returns total no.of products in database

      $stmt2->execute(); //executes the sql query

      $stmt2->bind_result($total_products); //stores result into a variable as array (its an array of result)

      $stmt2->store_result();

      $stmt2->fetch();

    ?>

    <?php

      $stmt3 = $conn->prepare("SELECT COUNT(*) FROM users"); //returns total no.of products in database

      $stmt3->execute(); //executes the sql query

      $stmt3->bind_result($total_users); //stores result into a variable as array (its an array of result)

      $stmt3->store_result();

      $stmt3->fetch();

    ?>

    <?php

      $stmt4 = $conn->prepare("SELECT COUNT(*) FROM admins"); //returns total no.of products in database

      $stmt4->execute(); //executes the sql query

      $stmt4->bind_result($total_admins); //stores result into a variable as array (its an array of result)

      $stmt4->store_result();

      $stmt4->fetch();

    ?>

      <?php

        $stmt5 = $conn->prepare("SELECT * FROM orders WHERE YEAR(order_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(order_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)"); //returns total no.of products in database

        $stmt5->execute();

        $result = $stmt5->get_result();

      ?>

    <?php

      $stmt6 = $conn->prepare("SELECT COUNT(*) FROM orders WHERE NOT order_status = 'not paid' AND YEAR(order_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(order_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) "); //returns total no.of products in database

      $stmt6->execute(); //executes the sql query

      $stmt6->bind_result($total_orders); //stores result into a variable as array (its an array of result)

      $stmt6->store_result();

      $stmt6->fetch();

    ?>

    <!-- CHART -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Price'],
          <?php
            while($data=mysqli_fetch_array($result)){

          
              
              $date = $data['order_date']; 
              $price = $data['order_cost'];
              // $expenses = $data['expenses'];
              // $profit = $data['profit'];
          ?>
          ['<?php echo $date;?>',<?php echo $price;?>],
          <?php } ?>
        ]);

        var options = {
          chart: {
            title: 'Daily Sales Report',
          },
          bars: 'vertical', // Required for Material Bar Charts.
          colors: ['#fb774b', '#fb774b', '#fb774b', '#fb774b', '#fb774b']
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
  </script>


    <div class="card m-b-30">
            <center><h5 class="mt-4">Previous Month Sales Report</h5></center>

        <div class="card-body">                 
            <div class="d-flex row justify-content-around" style="width:100%;">

                    <div class="divTwo border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='dashboard_details/paid_orders.php?option=previousMonthPaidOrders';">
                        <h5 class="card-title mb-1"><?php echo $total_orders; ?></h5>
                        <p class="mb-0">Paid Orders</p>
                    </div>

                    <div class="divOne border-primary border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='dashboard_details/view_payments.php?option=previousMonthPayments';">
                        <h5 class="card-title text-primary mb-1"><?php echo $total_rows; ?></h5>
                        <p class="text-primary mb-0">Total Payments</p>
                    </div>
            
                    <div class="divTwo border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='index.php';">
                        <h5 class="card-title mb-1">₹ <?php echo $total_revenue; ?></h5>
                        <p class="mb-0">Total Revenue</p>
                    </div>
                  
                    <div class="divThree border-warning border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='products.php';">
                        <h5 class="card-title text-warning mb-1"><?php echo $total_products; ?></h5>
                        <p class="text-warning mb-0">Total Products</p>
                    </div> 
                    
                    <div class="divFive border-danger border rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='dashboard_details/admin_details.php';">
                        <h5 class="card-title text-danger mb-1"><?php echo $total_admins; ?></h5>
                        <p class="text-danger mb-0">Admins</p>
                    </div>

                    <div class="divSix rounded text-center py-3 mb-3 col-sm-4" style="width: 300px;" onclick="location.href='users.php';">
                        <h5 class="card-title mb-1"><?php echo $total_users; ?></h5>
                        <p class="mb-0">Registerd Users</p>
                    </div> 


              </div>
        </div>
        
        <center><div id="barchart_material" style="width: 900px; height: 500px; padding-left: 50px; padding-top: 50px; margin-bottom: 50px"></div></center>

    </div>
    
<?php } ?>

    </main>
  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="dashboard.js"></script>

  </body>
</html>
