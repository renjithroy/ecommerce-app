<?php 

  if(!isset($_SESSION['admin_logged_in'])) {
      header('location: login.php');
      exit;
  
  }

?>
<style>

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

<header class="header" role="banner">
  <h1 class="logo">
    <a href="dashboard.php"><span>weaved</span></a>
  </h1>
  <div class="nav-wrap">
    <nav class="main-nav" role="navigation">
      <ul class="unstyled list-hover-slide">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="report.php">Report</a></li>
        <li><a href="index.php">Orders</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="add_product.php">Add New Product</a></li>
        <li><a href="category.php">Category</a></li>
        <li><a href="users.php">Registered Users</a></li>
        <li><a href="payment.php">Payments</a></li>
        <li><a href="contact.php">Enquiries</a></li>
        <li><a href="account.php">Admin Account</a></li>
        <li><?php if(isset($_SESSION['admin_logged_in'])) {?>
            <a href="logout.php?logout=1">Sign Out</a>
        <?php } ?></li>
      </ul>
    </nav>
  </div>
</header>