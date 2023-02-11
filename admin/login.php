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



<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<?php if(isset($_GET['error'])) {?>
					<div style=" width:60%;
					text-align: center;
					color: white;
					background-color: rgb(210, 43, 43);
					padding:15px;
					border:1px solid #eee;
					border-radius: 10px;
					margin: 0 auto 30px auto;
					font-size: 15px;
					"><?php echo "Sorry, ".$_GET['error'];?></div>
				<?php } ?>
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>


				<form class="login100-form validate-form" id="login-form" enctype="multipart/form-data" method="POST" action="login.php">


					<span class="login100-form-title">
						Admin Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="login_btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="../index.php">
							<i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
							Go back to homepage
						</a>
					</div>

				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>