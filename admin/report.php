<?php include('header.php'); ?>

<?php 

  if(!isset($_SESSION['admin_logged_in'])) {
      header('location: login.php');
      exit;
  
  }

?>

<style>
    input[type="date"] {
  display:block;
  position:relative;

  
  font-size:1rem;
  font-family:monospace;
  
  border:1px solid #8292a2;
  border-radius:0.25rem;
  background:
    white
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='22' viewBox='0 0 20 22'%3E%3Cg fill='none' fill-rule='evenodd' stroke='%23688EBB' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' transform='translate(1 1)'%3E%3Crect width='18' height='18' y='2' rx='2'/%3E%3Cpath d='M13 0L13 4M5 0L5 4M0 8L18 8'/%3E%3C/g%3E%3C/svg%3E")
    right 1rem
    center
    no-repeat;
  
  cursor:pointer;
}
input[type="date"]:focus {
  outline:none;
  border-color:#3acfff;
  box-shadow:0 0 0 0.25rem rgba(0, 120, 250, 0.1);
}

::-webkit-datetime-edit {}
::-webkit-datetime-edit-fields-wrapper {}
::-webkit-datetime-edit-month-field:hover,
::-webkit-datetime-edit-day-field:hover,
::-webkit-datetime-edit-year-field:hover {
  background:rgba(0, 120, 250, 0.1);
}
::-webkit-datetime-edit-text {
  opacity:0;
}
::-webkit-clear-button,
::-webkit-inner-spin-button {
  display:none;
}
::-webkit-calendar-picker-indicator {
  position:absolute;
  width:2.5rem;
  height:100%;
  top:0;
  right:0;
  bottom:0;
  
  opacity:0;
  cursor:pointer;
  
  color:rgba(0, 120, 250, 1);
  background:rgba(0, 120, 250, 1);
 
}

input[type="date"]:hover::-webkit-calendar-picker-indicator { opacity:0.05; }
input[type="date"]:hover::-webkit-calendar-picker-indicator:hover { opacity:0.15; }

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

td{
    padding-top: 10px !important;
    padding-bottom: 10px !important;
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
    padding: 10px 6px !important;
    font-weight: 400;
}

.filter-btn:hover{
    background-color: #1434A4 !important;
    border-color: #0047AB !important;
}

</style>
<div class="container-fluid mt-3">
  <div class="row" style="min-height: 1000px">

    <?php include('sidemenu.php') ?>

    <main>
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2" style="padding-left: 42rem">Report</h1>
      </div>

<form action="" method="GET">
    <div class="row mb-4 mt-4">
        <div class="col-2"></div>
        <div class="col-2">
            <div class="form-group">
                <label for="">From Date</label>
                <input type="date" name="from_date" class="form-control" value="<?php if(isset($_GET['from_date'])) { echo $_GET['from_date']; } ?>">
                <?php $_SESSION['from_date'] = $_GET['from_date'] ?>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label for="">To Date</label>
                <input type="date" name="to_date" class="form-control" value="<?php if(isset($_GET['to_date'])) { echo $_GET['to_date']; } ?>">
                <?php $_SESSION['to_date'] = $_GET['to_date'] ?>
            </div>
        </div>
        <div class="col-1">
            <div class="form-group">
                <label></label>
                <br>
                <button type="submit" class="btn btn-primary filter-btn" name="filter_btn" style="width: 110px; background-color: #0047AB; border-color: #0047AB;">Filter</button>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label></label>
                <br>
                <button type="button" class="btn btn-danger" onclick="window.location.href ='print_process.php'; " name="pdf_btn" style="color: #fff; width: 140px;">Print Report</button>
            </div>
        </div>
        
        
    </div>
</form>
    <!-- <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script> -->

    <div class="row">
        <div class= "col-2"></div>

        <div class="col-10">

        <div class="table-responsive">
            
            <table class="table table-striped table-sm text-center">
                
                <?php
                    if(isset($_GET['filter_btn'])){
                    if(isset($_GET['from_date']) && isset($_GET['to_date']) && $_GET['from_date'] != '' && $_GET['to_date'] != '') { //date set and date not empty
                        $from_date = $_GET['from_date'];
                        $to_date = $_GET['to_date'];

                        $query = "SELECT * FROM orders WHERE order_date BETWEEN '$from_date' AND '$to_date' ";
                        $orders = mysqli_query($conn, $query);
                            
                            if(mysqli_num_rows($orders) > 0){
                                ?>
                                    <thead>
                                        <tr class="text-center">
                                        <th scope="col">Order Id</th>
                                        <th scope="col">Order Status</th>
                                        <th scope="col">User Id</th>
                                        <th scope="col">Order Date</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">User Email</th>
                                        <th scope="col">User Phone</th>
                                        <th scope="col">User Address</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                <?php

                                foreach($orders as $order) 
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $order['order_id'] ?></td>
                                        <td><?php echo $order['order_status'] ?></td>
                                        <td><?php echo $order['user_id'] ?></td>
                                        <td><?php echo $order['order_date'] ?></td>
                                        <td><?php echo $order['user_name'] ?></td>
                                        <td><?php echo $order['user_email'] ?></td>
                                        <td><?php echo $order['user_phone'] ?></td>
                                        <td><?php echo $order['user_address'] ?></td>
                                    </tr>

                                <?php } ?>
                                
                                <?php
                            }
                            else
                            {
                                    ?><td style="padding: 20px !important"; "><?php echo "No Records Found"; ?></td>
                                    <?php
                            }
                            
                        
                    }else if($_GET['from_date'] === '' || $_GET['to_date'] === ''){ //if either one of the date is empty, display error
                        ?>
                        
                                <div style=" width:25%;
                                padding:20px;
                                border:1px solid #eee;
                                border-left-width:5px;
                                border-radius: 3px;
                                margin-left:250px;
                                font-size: 15px;
                                border-left-color: #d9534f;
                                background-color: rgba(217, 83, 79, 0.1);
                                "><strong style="color: #d9534f; font-size: 15px; letter-spacing: 0.6px">Error - Select a Date Range</strong> </div>

                        <?php
                    }
                }
                ?>

            
                </tbody>
                
            </table>
            
        </div>
        
    </div>

    </main>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
  </body>
</html>
