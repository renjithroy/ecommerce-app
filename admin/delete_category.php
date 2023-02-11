<?php 
session_start();
include('../server/connection.php');
?>

<?php 

  if(!isset($_SESSION['admin_logged_in'])) {
      header('location: login.php');
      exit;
  
  }

  if(isset($_GET['category_id'])){

    $category_id = $_GET['category_id'];
    
    $stmt1 = $conn->prepare("DELETE FROM category WHERE id=?");

    $stmt1->bind_param('i',$category_id);
    
    if($stmt1->execute())
    {
    header('location: category.php?deleted_successfully=Category has been deleted successfully');
    }
    else
    {
    header('location: category.php?deleted_failure=Category could not be deleted');
    }

  }


?> 