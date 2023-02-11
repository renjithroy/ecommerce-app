<?php include('header.php') ?>

<?php

include('../server/connection.php');

//already logged in
if(isset($_SESSION['admin_logged_in'])){
  header('location: index.php');
  exit;
}

if(isset($_POST['login_btn'])){

  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $stmt = $conn->prepare("SELECT admin_id,admin_name,admin_email,admin_password FROM admins WHERE admin_email=? AND admin_password=? LIMIT 1");

  $stmt->bind_param('ss',$email,$password);

  if($stmt->execute()){

      $stmt->bind_result($admin_id,$admin_name,$admin_email,$admin_password); //binding variables to these result
      $stmt->store_result();
      
      if($stmt->num_rows() == 1){
        $stmt->fetch(); //fetch value from database

        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['admin_name'] = $admin_name;
        $_SESSION['admin_email'] = $admin_email;
        $_SESSION['admin_logged_in'] = true;

        header('location: dashboard.php?login_success=Logged in Successfully');
        
      }else{
        //if user doesnt exist, i.e num_row not equal to 1
        header('location: login.php?error=could not verify your account');

      }

    
  }else{
    //error
    header('location: login.php?error=something went wrong');
  }

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
.logo a:hover {
  color: #fff;
}
.logo a:hover span {
  color: #DF4500;
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
<!-- <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active sidemenu-links" aria-current="page" href="dashboard.php">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link sidemenu-links" href="index.php">
              <span data-feather="file"></span>
              Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link sidemenu-links" href="products.php">
              <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link sidemenu-links" href="account.php">
              <span data-feather="users"></span>
              Account
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link sidemenu-links" href="add_product.php">
              <span data-feather="bar-chart-2"></span>
              Add New Product
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link sidemenu-links" href="users.php">
              <span data-feather="bar-chart-2"></span>
              Registered Users
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link sidemenu-links" href="category.php">
              <span data-feather="bar-chart-2"></span>
              Manage Category
            </a>
          </li>
        </ul>

     
      </div>
</nav> -->
<header class="header" role="banner">
  <h1 class="logo">
    <a href="#"><span>weaved</span></a>
  </h1>
</header>
<div class="container-fluid">
  <div class="">
   

    <main class="col-md-6 mx-auto col-lg-6 px-md-4 text-center">
      

    

      <h2>Login</h2>
      <div class="table-responsive">
      


          <div class="mx-auto container">
              <form id="login-form"  enctype="multipart/form-data" method="POST" action="login.php">
                <div class="form-group mt-2">
                  <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
                    <label>Email</label>
                    <input type="email" class="form-control" id="product-name" name="email" placeholder="Email" required/>
                </div>
                  <div class="form-group mt-2">
                      <label>Password</label>
                      <input type="password" class="form-control" id="product-desc" name="password" placeholder="Password" required/>
                  </div>
              


                <div class="form-group mt-3">
                    <input type="submit" class="btn btn-primary" name="login_btn" value="Login"/>
                </div>
 
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
