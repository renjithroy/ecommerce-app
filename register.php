<?php include('layouts/header.php') ?>

<?php

include('server/connection.php');

// if user has already registered, take user to accounts page
if(isset($_SESSION['logged_in'])){
  header('location: account.php'); 
  exit;
}


if(isset($_POST['register'])){
  
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

    if($password !== $confirmPassword)
    {
      header('location: register.php?error=Password doesnt match');
    }
    else if(strlen($password) < 6)
    {
      header('location: register.php?error=Password must be at least 6 characters');
    }
    else   // if there are no validation error
    {
      // checks whether there is a existing user with this email or not
      $stmt1 = $conn->prepare("SELECT count(*) FROM users where user_email = ?");
      $stmt1->bind_param('s',$email);
      $stmt1->execute();
      $stmt1->bind_result($num_rows); //binds the no.of rows to $num_rows variable
      $stmt1->store_result(); //stores executed result from sql statement
      $stmt1->fetch(); //allows the page to use the result, i.e num_rows

        if($num_rows != 0)
          {
            header('location: register.php?error=User with this email already exists');
          }
        else
          {
            // create a new user
            $stmt = $conn->prepare("INSERT INTO users(user_name,user_email,user_password)
                          VALUES(?,?,?)");

            $stmt->bind_param('sss',$name,$email,md5($password));
            // if account was created successfully
            if($stmt->execute()){ // storing user details in session
              $user_id = $stmt->insert_id;
              $_SESSION['user_id'] = $user_id;
              $_SESSION['user_email'] = $email;
              $_SESSION['user_name'] = $name;
              $_SESSION['logged_in'] = true;
              header('location: account.php?register_success=You registered successfully');
            }
            // account could not be created
            else{
              header('location: register.php?register=could not create an account at the moment');
            }

          }
    }

}

?>



    <!-- Register -->
    <section class="my-5 py-5">
      <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">Register</h2>
        <hr class="mx-auto" />
        <!-- margin right and left auto -->
      </div>
      <div class="mx-auto container">
        <form id="register-form" method="POST" action="register.php">

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
              <label for="register-name">Name</label>
              <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required>
          </div>
          <div class="form-group">
              <label for="register-email">Email</label>
              <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required>
          </div>
          <div class="form-group">
              <label for="register-password">Password</label>
              <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
          </div>
          <div class="form-group">
              <label for="register-confirm-password">Confirm Password</label>
              <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Re-enter your password" required>
          </div>
          <div class="form-group">
              <input type="submit" class="btn" id="register-btn" value="Register" name="register">
          </div>
          <div class="form-group">
              <a href="login.php" id="login-url" class="btn">Already have an account? Login</a>
          </div>
        </form>
      </div>
    </section>


    
<?php include('layouts/footer.php') ?>