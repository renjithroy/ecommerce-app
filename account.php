<?php include('layouts/header.php') ?>
<?php

include('server/connection.php');

//if user is not logged in
if(!isset($_SESSION['logged_in'])){
  header('location: login.php');
  exit;
}


if(isset($_GET['logout'])){
  if(isset($_SESSION['logged_in'])){
    unset($_SESSION['logged_in'] );
    unset($_SESSION['user_email'] );
    unset($_SESSION['user_name'] );

    header('location: login.php');
    exit;
  }
}

if(isset($_POST['change_password'])){

          $password = $_POST['password'];
          $confirmPassword = $_POST['confirmPassword'];
          $user_email = $_SESSION['user_email'];

          //if passwords dont match
          if($password !== $confirmPassword){
            header("location: account.php?error=Passwords doesn't match");
          

          //if passwod is less than 6 char
          }else if(strlen($password) < 6){
            header('location: account.php?error=Password must be at least 6 characters');

            //no errors
          }else{
             
            $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
            $stmt->bind_param('ss',md5($password),$user_email);

            if($stmt->execute()){
              header('location: account.php?message=Password updated successfully');
            }else{
              header('location: account.php?error=Sorry, could not update your password');
            }
            
          } 
}

//get orders

if(isset($_SESSION['logged_in'])){

  $user_id = $_SESSION['user_id'];

  $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ");

  $stmt->bind_param('i',$user_id);

  $stmt->execute(); //executes the sql query

  $orders = $stmt->get_result(); //[]

}
?>



  <!-- Account -->
  <section class="my-5 py-5">
    <div class="row container mx-auto">

      <?php if(isset($_GET['payment_message'])) { ?>
          <p class="mt-5 text-center" style="color: green; font-weight: 700; font-size: 25px; filter: none; "> <?php echo $_GET['payment_message']; ?> </p>
      <?php }?>
    
    
   
      <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">

          <?php if(isset($_GET['register_success'])) {?>
            <div style=" width:80%;
            background-color: #ffffff;
            padding:20px;
            border:1px solid #eee;
            border-left-width:5px;
            border-radius: 3px;
            margin:10px auto;
            font-size: 15px;
            border-left-color: #2b542c;
            background-color: rgba(43, 84, 44, 0.1);
            "><?php echo $_GET['register_success'];?></div>
          <?php } ?>


          <?php if(isset($_GET['login_success'])) {?>
            <div style=" width:80%;
            background-color: #ffffff;
            padding:20px;
            border:1px solid #eee;
            border-left-width:5px;
            border-radius: 3px;
            margin:10px auto;
            font-size: 15px;
            border-left-color: #2b542c;
            background-color: rgba(43, 84, 44, 0.1)
            "><?php echo $_GET['login_success'];?></div>
          <?php } ?>

        <h3 class="font-weight-bold">Account Info</h3>
        <hr class="mx-auto" />
        <div class="account-info">
          <p>Name: <span><?php if(isset($_SESSION['user_name'])) { echo $_SESSION['user_name']; } ?></span></p>
          <p>Email: <span><?php if(isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; } ?></span></p>
          <p><a href="#orders" id="orders-btn">Your orders</a></p>
          <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
        </div>
      </div>

      <div class="col-lg-6 col-md-12 col-sm-12">
          
        <form action="account.php" id="account-form" method="POST">

          <?php if(isset($_GET['error'])) {?>
            <div style=" width:100%;
            background-color: #ffffff;
            padding:20px;
            border:1px solid #eee;
            border-left-width:5px;
            border-radius: 3px;
            margin:10px auto;
            font-size: 15px;
            border-left-color: #d9534f;
            background-color: rgba(217, 83, 79, 0.1);
            "><strong style="color: #d9534f; font-size: 15px; letter-spacing: 0.6px">Error</strong> - 
            <?php echo $_GET['error'];?></div>
          <?php } ?>

          <?php if(isset($_GET['message'])) {?>
            <div style=" width:100%;
            background-color: #ffffff;
            padding:20px;
            border:1px solid #eee;
            border-left-width:5px;
            border-radius: 3px;
            margin:10px auto;
            font-size: 15px;
            border-left-color: #2b542c;
            background-color: rgba(43, 84, 44, 0.1);
            "><?php echo $_GET['message'];?></div>
          <?php } ?>


          <h3>Change Password</h3>
          <hr class="mx-auto" />
          <div class="form-group">
            <label for="account-password">Password:</label>
            <input type="password" class="form-control" id="account-password" name="password" placeholder="Password"
              required />
          </div>
          <div class="form-group">
            <label for="account-password">Confirm Password:</label>
            <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword"
              placeholder="Re-enter your password" required />
          </div>
          <div class="form-group">
            <input type="submit" value="Change Password" class="btn" id="change-pass-btn" name="change_password"/>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Orders -->
  <section id="orders" class="orders container my-5 py-1">
    <div class="container mt-2">
      <h2 class="font-weight-bold text-center">Your Orders</h2>
      <hr style="width: 80px" class="mx-auto" />
    </div>
    <table class="mt-5 pt-5">
      <tr>
        <th>Order id</th>
        <th>Order Cost</th>
        <th>Order Status</th>
        <th>Order Date</th>
        <th>Order Details</th>
      </tr>

      <?php while($row = $orders->fetch_assoc() ) { ?>

        <tr>

          <td>
            <div class="product-info">
              <!-- <img src="assets/images/featured1.jpeg" /> -->
              <div>
                <p class="mt-3"><?php echo $row['order_id']; ?></p>
              </div>
            </div>
          </td>

          <td>
            <span><?php echo $row['order_cost']; ?></span>
          </td>

          <td>
            <span><?php echo $row['order_status']; ?></span>
          </td>

          <td>
            <span><?php echo $row['order_date']; ?></span>
          </td>

          <td>
            <form method="POST" action="order_details.php">
              <input type="hidden" value="<?php echo $row['order_status'];?>" name="order_status"/>
              <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
              <input class="btn order-details-btn" name="order_details_btn" value="details" type="submit">
            </form>
          </td>

        </tr>

      <?php } ?>
    </table>
  </section>



<?php include('layouts/footer.php') ?>
