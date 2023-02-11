<?php include('layouts/header.php') ?>

<?php

if(isset($_POST['order_pay_btn'])){
  $order_status = $_POST['order_status'];
  $order_total_price = $_POST['order_total_price'];
}


?>



  <!-- Payment -->
  <section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
      <h2 class="form-weight-bold">Payment</h2>
      <hr class="mx-auto" />
      <!-- margin right and left auto -->
    </div>
    <div class="mx-auto container text-center">
        

        <!-- Checks the order status. Order status is created if an order is placed. If user came through accounts page--> 
        <?php if(isset($_POST['order_status']) && $_POST['order_status'] == "not paid"){ ?>
            <?php $amount = strval($_POST['order_total_price']); ?>
            <?php $order_id = $_POST['order_id']; ?>
            <p style="font-weight: 700;">Total Payment: Rs <?php echo $_POST['order_total_price']; ?></p>
            <!-- <input type="submit" class="btn btn-primary" value="Pay Now"> -->
            <div id="paypal-button-container"></div>


        <!-- if cart is not empty -->
        <?php } else if(isset($_SESSION['total']) && $_SESSION['total']!=0) { ?>
            <?php $amount = strval($_SESSION['total']); ?>
            <?php $order_id = $_SESSION['order_id']; ?>
            <p style="font-weight: 700; filter: none;">Total payment: Rs <?php echo $_SESSION['total']; ?></p>
            <!-- <input type="submit" class="btn btn-primary" value="Pay Now"> -->
            <div id="paypal-button-container"></div>

            
        <?php } else{?>
            <p style="font-weight: 700; filter: none">You don't have an order</p>  
        <?php } ?>


    </div>
  </section>

    <!-- Connect to paypal -->
    <script src="https://www.paypal.com/sdk/js?client-id=AXknWn63oXt0xp1RbkufoM6thryy_xIeKatU1G-C7Rg-K5fDDgVxCYPXd5oMF914ZUXXynLnXwBHfKxx&currency=USD"></script>
    <!-- Set up a container element for the button -->

    <script>
      // Creates a button
      paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '<?php echo $amount; ?>' // Can also reference a variable or function
              }
            }]
          });
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
          return actions.order.capture().then(function(orderData) {
            // Successful capture! For dev/demo purposes:
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            const transaction = orderData.purchase_units[0].payments.captures[0];
            alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);

            window.location.href="server/complete_payment.php?transaction_id="+transaction.id+"&order_id="+<?php echo $order_id; ?>;
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  actions.redirect('thank_you.html');
          });
        }
      }).render('#paypal-button-container');
    </script>


<?php include('layouts/footer.php') ?>