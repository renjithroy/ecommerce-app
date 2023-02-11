<?php
session_start();

$conn = mysqli_connect("localhost","root","root","weaved") or die("Couldn't Connect to database");

require('vendorpdf/autoload.php');

    $from_date = $_SESSION['from_date'];
    $to_date = $_SESSION['to_date'];

    $query = "SELECT * FROM orders WHERE order_date BETWEEN '$from_date' AND '$to_date' ";
    $orders = mysqli_query($conn, $query);

    if(mysqli_num_rows($orders)>0){
        $html=' <h2 style="text-align: center;">Sales Report</h2>
        <style>table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
            }
            th {
            letter-spacing: 2px;
            }
            thead tr{
                background: #0047AB;
            }
            thead tr th{
                color: #fff;
            }
            tr td{
                text-align: center;
            }
</style><table class="table">';
            $html.='<thead>><tr><th>Order ID</th><th>Order Status</th><th>User Name</th><th>User Email</th><th>User Phone</th><th>User Address</th><th>Order Date</th></tr></thead>';
            while($row=mysqli_fetch_assoc($orders)){
                $html.='<tr><td>'.$row['order_id'].'</td><td>'.$row['order_status'].'</td><td>'.$row['user_name'].'</td><td>'.$row['user_email'].'</td><td>'.$row['user_phone'].'</td><td>'.$row['user_address'].'</td><td>'.$row['order_date'].'</td></tr>';
            }
        $html.='</table>';
    }else{
        $html="Data not found";
    }

    $mpdf=new \Mpdf\Mpdf();
    $mpdf->SetHeader('{PAGENO}');

    $mpdf->WriteHTML($html);
    $file='salesreport'.'.pdf';
    $mpdf->output($file,'I');
    
 ?>