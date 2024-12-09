<?php

include "../config.php";

session_start();

if(!isset($_SESSION['user_id'])){
   header('location:login.php');
};

$user_id = $_SESSION['user_id'];

// query order details here
$sql = "SELECT * FROM `orders` WHERE id = {$_GET['id']}";
$query = mysqli_query($conn, $sql);
$order = mysqli_fetch_assoc($query);

// Add the notes column if it doesn't exist
// You can run the following SQL command in your database to add the column
// ALTER TABLE orders ADD COLUMN notes TEXT;

?>

<?php 
   include 'header.php'; 
   include 'navbar.php'; 
?>
<section class="dashboard">
   <h3 class="title">Order Details</h3>
   <div class="box-container">
      <div class="box" style="margin-left:20%;margin-right:20%;">
         <form method="POST">
            <table style="width:100%;" border="1">
               <tr>
                  <td class="td-form">
                     <label><b>Order Id: </b>WCOR00<?= $order['id'] ?></label><br>
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label><b>Phone: </b><?= $order['number'] ?></label><br>
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label><b>Email: </b><?= $order['email'] ?></label><br>
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label><b>Payment Method: </b><?= $order['method'] ?></label><br>
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label><b>Products: </b><?= $order['total_products'] ?></label><br>
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label><b>Price: </b>₱<?= number_format($order['total_price'], 2) ?></label><br>
                  </td>
               </tr>
               <tr> 
                  <td class="td-form">
                     <label><b>Date Ordered: </b><?= $order['placed_on'] ?></label><br>
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label><b>Notes: </b><?= $order['notes'] ?></label><br>
                  </td>
               </tr>
               <tr>
                  <td class="td-form">
                     <label><b>Status: </b><?= $order['payment_status'] ?></label><br>
                  </td>
               </tr>
            </table>
            <br>
         </form>
      </div>
   </div>
</section>

<?php
// Insert Notes into the Order table (if updating) and other order details
if (isset($_POST['submit'])) {
   $notes = mysqli_real_escape_string($conn, $_POST['notes']);

   $sql_update = "UPDATE orders SET notes = '$notes' WHERE id = {$_GET['id']} AND user_id = $user_id";
   if (mysqli_query($conn, $sql_update)) {
      // Save to audit trail
      $user_id = $_SESSION['user_id'];
      $sql = "INSERT INTO audit_trail (user_id, description) VALUES ($user_id, 'User updated order notes')";
      mysqli_query($conn, $sql);

      echo "<script> alert('Order notes updated successfully');</script>";
      echo "<script>window.location.replace('order-details.php?id={$_GET['id']}');</script>";
   } else {
      echo "<script> alert('Error updating order notes');</script>";
   }
}
?>

<script src="../js/admin_script.js"></script>
</body>
</html>
