<?php session_start(); ?>
<?php 

  if(!isset($_SESSION['admin_logged_in'])) {
      header('location: ../login.php');
      exit;
  
  }

?>

<?php include('../../server/connection.php'); ?>


<?php

    $stmt1 = $conn->prepare("SELECT * FROM admins");

    $stmt1->execute();

    $adminInfo = $stmt1->get_result();

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
    <!-- Custom styles for this template -->
  </head>
  <body>
    
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

.btn-primary {
    background-color: #fb774b;
    border-color: #fb774b;
}
.btn-primary:hover {
    background-color: #f95a25 !important;
    border-color: #fb774b;
}

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

@import "compass/css3";
*, :before, :after {
  box-sizing: border-box;
}
.unstyled {
  list-style: none;
  padding: 0;
  margin: 0;
}
.unstyled a {
  text-decoration: none;
}
.list-inline {
  overflow: hidden;
}
.list-inline li {
  float: left;
}
.header {
  position: fixed;
  left: 0;
  top: 0;
  bottom: 0;
  width: 15em;
  background: #35302D;
}
.logo {
  text-transform: lowercase;
  font: 300 2em 'Source Sans Pro', Helvetica, Arial, sans-serif;
  text-align: center;
  padding: 0;
  margin: 0;
}
.logo a {
  display: block;
  padding: 1em 0;
  color: #DFDBD9;
  text-decoration: none;
  transition: 0.15s linear color;
}

.logo span {
  font-weight: 700;
  transition: 0.15s linear color;
}
.main-nav ul {
  border-top: solid 1px #3C3735;
}
.main-nav li {
  border-bottom: solid 1px #3C3735;
}
.main-nav a {
  padding: 1.1em 0;
  color: #DFDBD9;
  font: 400 1.125em 'Source Sans Pro', Helvetica, Arial, sans-serif;
  text-align: center;
  /* text-transform: uppercase; */
}
.main-nav a:hover {
  color: #fff;
}
.social-links {
  border-bottom: solid 1px #3C3735;
}
.social-links li {
  width: 25%;
  border-left: solid 1px #3C3735;
}
.social-links li:first-child {
  border: none;
}
.social-links a {
  display: block;
  height: 5.5em;
  text-align: center;
  color: #3C3735;
  font: 0.75em/5.5em 'Source Sans Pro', Helvetica, Arial, sans-serif;
}
.social-links a:hover {
  color: #DFDBD9;
}
.list-hover-slide li {
  position: relative;
  overflow: hidden;
}
.list-hover-slide a {
  display: block;
  position: relative;
  z-index: 1;
  transition: 0.35s ease color;
}
.list-hover-slide a:before {
  content: '';
  display: block;
  z-index: -1;
  position: absolute;
  left: -100%;
  top: 0;
  width: 100%;
  height: 100%;
  border-right: solid 5px #DF4500;
  background: #3C3735;
  transition: 0.35s ease left;
}
.list-hover-slide a.is-current:before, .list-hover-slide a:hover:before {
  left: 0;
}

</style>


<div class="container-fluid">
  <div class="row" style="min-height: 1000px">


<header class="header" role="banner">
  <h1 class="logo">
    <a href="dashboard.php"><span>weaved</span></a>
  </h1>
  <div class="nav-wrap">
    <nav class="main-nav" role="navigation">
      <ul class="unstyled list-hover-slide">
        <li><a href="../dashboard.php">Dashboard</a></li>
        <li><a href="../report.php">Report</a></li>
        <li><a href="../index.php">Orders</a></li>
        <li><a href="../products.php">Products</a></li>
        <li><a href="../add_product.php">Add New Product</a></li>
        <li><a href="../category.php">Category</a></li>
        <li><a href="../users.php">Registered Users</a></li>
        <li><a href="../payment.php">Payments</a></li>
        <li><a href="../account.php">Admin Account</a></li>
        <li><?php if(isset($_SESSION['admin_logged_in'])) {?>
            <a href="../logout.php?logout=1">Sign Out</a>
        <?php } ?></li>
      </ul>
    </nav>
  </div>
</header>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 ">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" style="margin-bottom: 20px !important;">
        <h1 class="h2" style="padding-left: 28rem">Admin Info</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
          
          </div>
     
        </div>
      </div>

      <div class="table-responsive" style="margin-top: 23px !important">
        <table class="table table-striped table-sm text-center sortable">
          <thead>
            <tr class="text-center">
              <th scope="col">Admin Id</th>
              <th scope="col">Admin Name</th>
              <th scope="col">Admin Email</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($adminInfo as $admin) { ?>
                <tr>
                  <td><?php echo $admin['admin_id'] ?></td>
                  <td><?php echo $admin['admin_name'] ?></td>
                  <td><?php echo $admin['admin_email'] ?></td>
                </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
        <script src="dashboard.js"></script>
    </body>
</html>