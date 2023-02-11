<?php include('layouts/header.php') ?>

<?php

include('server/connection.php');

if(isset($_SESSION['logged_in'])){
  header('location: account.php');
  exit;
}

if(isset($_POST['login_btn'])){

  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $stmt = $conn->prepare("SELECT user_id,user_name,user_email,user_password FROM users WHERE user_email=? AND user_password=? LIMIT 1");

  $stmt->bind_param('ss',$email,$password);

  if($stmt->execute()){

      $stmt->bind_result($user_id,$user_name,$user_email,$user_password); //binding variables to these result
      $stmt->store_result();
      
      if($stmt->num_rows() == 1){
        $stmt->fetch(); //fetch value from database

        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_email'] = $user_email;
        $_SESSION['logged_in'] = true;

        header('location: account.php?login_success=Logged in Successfully');
        
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


    <!-- LOGIN -->
    <section class="my-5 py-5">
      <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Login</h2>
        <hr class="mx-auto" />
        <!-- margin right and left auto -->
      </div>
      <div class="mx-auto container">
        <form action="login.php" method="POST" id="login-form">
          
          <?php if(isset($_GET['error'])) {?>
            <div style=" width:80%;
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
          
          <div class="form-group">
              <label for="login-email">Email</label>
              <input type="email" class="form-control" id="login-email" name="email" placeholder="Email" required>
          </div>
          <div class="form-group">
              <label for="">Password</label>
              <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
          </div>
          <div class="form-group">
              <input type="submit" class="btn" id="login-btn" value="Login" name="login_btn">
          </div>
          <div class="form-group">
              <a href="register.php" id="register-url" class="btn">Don't have account? Register</a>
          </div>
        </form>
      </div>
    </section>


<?php include('layouts/footer.php') ?>
