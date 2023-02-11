<?php include('header.php'); ?>

<?php 

  if(!isset($_SESSION['admin_logged_in'])) {
      header('location: login.php');
      exit;
  
  }

?>

<?php

    $stmt1 = $conn->prepare("SELECT COUNT(*) As total_records FROM category"); //returns total no.of products in database

    $stmt1->execute(); //executes the sql query

    $stmt1->bind_result($total_records); //stores result into a variable as array (its an array of result)

    $stmt1->store_result();

    $stmt1->fetch();


  //4. Get all products

    $stmt2 = $conn->prepare("SELECT * FROM category");

    $stmt2->execute();

    $categories = $stmt2->get_result();

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
table thead tr th{
    padding: 10px 6px !important;
    font-weight: 400;
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

</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.1.1/css/fontawesome.min.css" integrity="sha384-zIaWifL2YFF1qaDiAo0JFgsmasocJ/rqu7LKYH8CoBEXqGbb9eO+Xi3s6fQhgFWM" crossorigin="anonymous">
<div class="container-fluid">
  <div class="row" style="min-height: 1000px">

    <?php include('sidemenu.php') ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 ">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" style="margin-bottom: 20px !important;">
        <h1 class="h2" style="padding-left: 28rem">Manage Category</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
          
          </div>
     
        </div>
      </div>



        <?php if(isset($_GET['edit_success_message'])) {?>
            <div style=" width:30%;
            color: green;
            background-color: #ffffff;
            padding:20px;
            border:1px solid #eee;
            border-left-width:5px;
            border-radius: 3px;
            margin: 0 auto 30px auto;
            font-size: 15px;
            border-left-color: #2b542c;
            background-color: rgba(43, 84, 44, 0.1);
            "><?php echo $_GET['edit_success_message'];?></div>
        <?php } ?>

        <?php if(isset($_GET['edit_failure_message'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['edit_failure_message']; ?></p>
        <?php } ?>

        <!-- Deleting products -->

        <?php if(isset($_GET['deleted_successfully'])) {?>
            <div style=" width:31%;
            color: green;
            background-color: #ffffff;
            padding:20px;
            border:1px solid #eee;
            border-left-width:5px;
            border-radius: 3px;
            margin: 0 auto 30px auto;
            font-size: 15px;
            border-left-color: #2b542c;
            background-color: rgba(43, 84, 44, 0.1);
            "><?php echo $_GET['deleted_successfully'];?></div>
        <?php } ?>

        <?php if(isset($_GET['deleted_failure'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['deleted_failure']; ?></p>
        <?php } ?>

        <!-- Adding new products -->

        <?php if(isset($_GET['category_created'])) {?>
            <div style=" width:31%;
            color: green;
            background-color: #ffffff;
            padding:20px;
            border:1px solid #eee;
            border-left-width:5px;
            border-radius: 3px;
            margin: 0 auto 30px auto;
            font-size: 15px;
            border-left-color: #2b542c;
            background-color: rgba(43, 84, 44, 0.1);
            "><?php echo $_GET['category_created'];?></div>
        <?php } ?>

        <?php if(isset($_GET['category_failed'])){ ?>
            <p class="text-center" style="color: red;"><?php echo $_GET['category_failed']; ?></p>
        <?php } ?>

      <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
         
        <a href="add_category.php" class="btn btn-success"><i class="fa-solid fa-plus"></i>  Add Category</a>

      <div class="table-responsive" style="margin-top: 23px !important">
        <table class="table table-striped table-sm text-center sortable">
          <thead>
            <tr class="text-center">
              <th scope="col">Category Id</th>
              <th scope="col">Category Description</th>
              <th scope="col">Edit Category</th>
              <th scope="col">Delete Category</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($categories as $category) { ?>
                <tr>
                  <td><?php echo $category['id'] ?></td>
                  <td><?php echo $category['cat_description'] ?></td>
                  <td><a class="btn btn-primary" href="edit_category.php?category_id=<?php echo $category['id']; ?>" style="font-size: 15px;">Edit</a></td>
                  <td><a class="btn btn-danger" href="delete_category.php?category_id=<?php echo $category['id']; ?>" style="font-size: 15px;">Delete</a></td>
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
